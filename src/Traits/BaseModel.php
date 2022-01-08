<?php

namespace Sdkconsultoria\Base\Traits;

use Sdkconsultoria\Helpers\Helpers;
use Illuminate\Support\Str;
use Base;

trait BaseModel
{
    /**
     * Obtiene los atributos por los cuales que se puede buscar
     * @return array
     */
    public function getFiltersAttribute()
    {
        return [
            'status' => [
                'type' => 'dropdown',
                'options' => $this->getStatus()
            ]
        ];
    }

    /**
     * Obtiene el nombre limpio de un atributo.
     *
     * @return String nombre limpio
     */
    public static function getLabel(string $attribute, string $package = '', string $class = '') : string
    {
        if (str_contains($attribute, '.')) {
            $explode = explode('.', $attribute);
            $model = get_called_class();
            $model = new $model;

            return $model->{$explode[0]}(true)::getLabel($explode[1]);
        }

        if ($package) {
            $package .= '::';
        } else {
            if (get_called_class()::$package) {
                $package = get_called_class()::$package . '::';
            }
        }

        if (!$class) {
            $class = Str::kebab(class_basename(get_called_class()));
        }

        $trans = $package . 'models.' . $class . '.' . $attribute;

        if (trans()->has($trans)) {
            return __($trans);
        }

        return __($package . 'models.common.' . $attribute);
    }

    /**
     * Gets the list of all columns.
     * @return array
     */
    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    /**
     * Check if a specific column exists or not.
     * @param  string  $column column to search
     * @return bool
     */
    public function hasColumn($column)
    {
        if (in_array($column, $this->getTableColumns())) {
            return true;
        }

        return false;
    }

    /**
     * Check if the selected filter exists.
     * @param  string  $attr searched filter
     * @return mixed         current filter or false if not exist
     */
    public function hasFilter($attr)
    {
        if (array_key_exists($attr, $this->filters)) {
            return $this->filters[$attr];
        }

        foreach ($this->filters as $key => $value) {
            if ($value == $attr) {
                return $attr;
            }
        }

        return false;
    }

    /**
     * Genera un Slug el cual puede ser unico o no
     * @param  string  $attribute    atributo del cual se debe generar el slug
     * @param  string  $slug         atributo donde se va a guardar el slig
     * @param  boolean $unique       determina si el slug debe ser unico o  no
     */
    public function generateSlug($attribute = 'name', $slug = 'seoname', $unique = true)
    {
        if (empty($this->id) or $this->isDirty($attribute)) {
            $count = $this::where($attribute, $this->$attribute)->count();
            $this->$slug = Str::slug($this->$attribute, '-');
            if ($unique) {
                if ($count) {
                    $count++;
                    $this->$slug = $this->$slug . '-' . $count;
                }
            }
        }
    }

    /**
     * Devuelve el usuario que creo el elemento
     * @return App\Models\User
     */
    public function createdBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    /**
     * Devuelve el ultimo usuario que modifico este elemento
     * @return App\Models\User
     */
    public function updatedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }

    /**
     * Devuelve usuario que elimino este elemento
     * @return App\Models\User
     */
    public function deletedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }

    /**
     * Obtiene los status de un modelo por defecto
     * @return array
     */
    public function getStatus()
    {
        return [
            self::STATUS_DELETED => __('base::models.status.deleted'),
            self::STATUS_CREATION => __('base::models.status.creation'),
            self::STATUS_ACTIVE => __('base::models.status.active'),
        ];
    }

    /**
     * Obtiene la ruta donde del objeto
     * @return string
     */
    public static function getRoute(string $name, $params = [])
    {
        return route(self::getClassName('kebab') . '.' . $name, $params);
    }

    public static function getClassName(string $type = '', bool $plural = true)
    {
        $class = get_class()::$route ?? (new \ReflectionClass(get_called_class()))->getShortName();

        switch ($type) {
            case 'kebab':
                $class = Str::kebab($class);
                break;

            case 'snake':
                $class = Str::snake($class);
                break;
        }

        $class = strtolower($class);

        if ($plural) {
            return Str::plural($class);
        }

        return $class;
    }

    public static function getTranslate(string $translate)
    {
        $female = self::gender();

        switch ($translate) {
            case 'create':
                return __('base::models.common.create', ['model' => self::getLabel('singular')]);

            case 'edit':
                return __('base::models.common.update', ['model' => self::getLabel('singular')]);

            case 'show':
                return __('base::models.common.show', ['model' => self::getLabel('singular')]);

            case 'delete':
                return __('base::models.common.delete', ['model' => self::getLabel('singular')]);

            case 'delete_question':
                return trans_choice('base::models.common.delete_question', $female, ['item' => self::getLabel('singular')]);

            case 'showed':
                return trans_choice('base::models.common.showed', $female, ['item' => self::getLabel('singular')]);

            case 'created':
                return trans_choice('base::models.common.created', $female, ['item' => self::getLabel('singular')]);

            case 'edited':
                return trans_choice('base::models.common.edited', $female, ['item' => self::getLabel('singular')]);

            case 'deleted':
                return trans_choice('base::models.common.deleted', $female, ['item' => self::getLabel('singular')]);

            case 'add-element':
                return trans_choice('base::models.common.add-element', $female, ['item' => self::getLabel('singular')]);

            default:
                // code...
                break;
        }
    }

    public function input(string $field)
    {
        return Base::input([
                    'name' =>  $this->getTable() . '_' . $field,
                    'value' => old($field) ?? $this->$field,
                    'placeholder' => '',
                    'model_remove' => $this,
                ])->setTranslate(self::getLabel($field));
    }

    public static function gender()
    {
        return strtolower(substr(self::getLabel('singular'), -1)) == 'a' ? 0 : 1;
    }

    public function getKeyId()
    {
        return $this->{$this::$keyId};
    }

    public static function updateRules($request)
    {
        return get_called_class()::rules($request);
    }

    public static function rules($request)
    {
        return [];
    }

    public function scopeStatus($query, $type)
    {
        return $query->where('status', $type);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public static function createEmpty()
    {
        $class = get_called_class();
        $user_id = auth()->user()->id;
        $model = $class::where('created_by', $user_id)->where('status', $class::STATUS_CREATION)->first();

        if ($model) {
            return $model;
        }

        $model = new $class;
        $model->created_by = $user_id;
        $model->save();

        return $model;
    }
}
