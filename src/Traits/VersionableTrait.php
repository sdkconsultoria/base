<?php

namespace Sdkconsultoria\Base\Traits;

use App\Models\Version;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait VersionableTrait
{
    /**
     * Private variable to detect if this is an update
     * or an insert.
     * @var bool
     */
    private $updating;

    /**
     * Contains all dirty data that is valid for versioning.
     *
     * @var array
     */
    private $versionableDirtyData;

    /**
     * Initialize model events.
     */
    public static function bootVersionableTrait()
    {
        static::saving(function ($model) {
            $model->versionablePreSave();
        });

        static::saved(function ($model) {
            $model->versionableSave();
        });
    }

    /**
     * Determine if a new version should be created for this model.
     *
     * @return bool
     */
    private function versioningData()
    {
        $dontVersionFields = $this->dontVersionFields ?? [];
        $removeableKeys = array_merge($dontVersionFields, [$this->getUpdatedAtColumn()]);

        if (method_exists($this, 'getDeletedAtColumn')) {
            $removeableKeys[] = $this->getDeletedAtColumn();
        }

        return array_diff_key($this->getDirty(), array_flip($removeableKeys));
    }

    /**
     * Pre save hook to determine if versioning is enabled and if we're updating
     * the model.
     * @return void
     */
    protected function versionablePreSave()
    {
        $this->versionableDirtyData = $this->getDirty();
        $this->updating = $this->exists;
    }

    protected function versionableSave()
    {
        $dirty_data = $this->versioningData();

        if ($this->updating && $dirty_data) {
            $version = new Version();
            $version->versionable_id = $this->getKey();
            $version->versionable_type = get_class($this);
            $version->user_id = Auth::user() ? Auth::user()->id : null;
            $version->version = count($this->versions) + 1;
            $version->model_data = json_encode($this->getOriginal());
            $version->save();

            if (isset($this->versionable_parent)) {
                $parent_id = Str::snake(class_basename($this->versionable_parent)) . '_id';
                $parent_model = $this->versionable_parent::where('id', $this->$parent_id)->first();

                $parent_version = new Version();
                $parent_version->type = 'children';
                $parent_version->versionable_id = $this->$parent_id;
                $parent_version->versionable_type = $this->versionable_parent;
                $parent_version->user_id = Auth::user() ? Auth::user()->id : null;
                $parent_version->version = count($parent_model->versions) + 1;
                $parent_version->model_data = json_encode([
                    'child_version' => $version->id,
                ]);
                $parent_version->save();
            }
        }
    }

    /**
     * Return all versions of the model.
     * @return MorphMany
     */
    public function versions()
    {
        return $this->morphMany('App\Models\Version', 'versionable');
    }

    /**
     * Returns the latest version available.
     * @return Version
     */
    public function previousVersion()
    {
        return $this->versions()->orderBy('created_at', 'DESC')->first();
    }

    /**
     * Returns the latest version available.
     * @return Version
     */
    public function specificVersion(string $version)
    {
        return $this->versions()->where('version', $version)->first();
    }
}
