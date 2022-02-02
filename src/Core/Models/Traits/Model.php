<?php

namespace Sdkconsultoria\Base\Core\Models\Traits;

use Sdkconsultoria\Helpers\Helpers;
use Illuminate\Support\Str;
use Base;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Http\Request;
use Sdkconsultoria\Base\Exceptions\APIException;

trait Model
{
    public $canCreateEmpty = true;

    public function save(array $options = [])
    {
        parent::save($options);
    }

    public function isAuthorize(string $action)
    {
        $auth_user = auth()->user();
        $permision = $this->getPermissionName($action);

        if ($auth_user->can($permision)) {
            return;
        }

        $is_super_admin = $auth_user->hasRole('super_admin');

        if ($is_super_admin) {
            return;
        }

        throw new APIException(['message' => __('base::responses.403')], 403);
    }

    public function getPermissionName(string $action) : string
    {
        $resouce = Str::snake(class_basename($this));

        return "$resouce:$action";
    }

    public function getFullAttributes()
    {
        if ($this->isTranstlatableModel()) {

            $translate_model =  $this->getTranslatableModel()->getAttributes();

            return array_merge(
                $translate_model,
                ['identifier' => $this->identifier]
            );
        }

        return $this->getAttributes();
    }

    public function getModelAttributes(string $rules = 'getValidationRules', $request = '') : array
    {
        $full_attributes = $this->getModelAttributesFromRules($rules, $request);

        if ($this->isTranstlatableModel()) {
            return $this->getModelAttributesTranslatable($full_attributes);
        }

        return $this->convertModelAttributesToArray($full_attributes, $this);
    }

    public function getModelAttributesFromCreateRules()
    {
        return $this->getModelAttributesFromRules();
    }

    public function getModelAttributesFromRules(string $rules = 'getValidationRules', $request = '') : array
    {
        $rules_array = $this->$rules($request);
        $attributes = [];

        foreach ($rules_array as $attribute => $rule) {
            array_push($attributes, $attribute);
        }

        return $attributes;
    }

    public function isTranstlatableModel()
    {
        return method_exists($this, 'getTranslatableClassOrFail');
    }

    public function getModelAttributesTranslatable(array $full_attributes) : array
    {
        unset($full_attributes['identifier']);
        $full_attributes = $this->convertModelAttributesToArray($full_attributes, $this->getTranslatableModel());

        $full_attributes['identifier'] = $this->identifier;

        return $full_attributes;
    }

    public function convertModelAttributesToArray(array $attributes, EloquentModel $model) : array
    {
        $attributes_array = [];

        foreach ($attributes as $attribute) {
            $attributes_array[$attribute] = $model->$attribute;
        }

        return $attributes_array;
    }

    public function getValidationRules($request = '') : array
    {
        return [];
    }

    public static function findModelOrCreate() : EloquentModel
    {
        $model = get_called_class()::where('created_by', auth()->user()->id)
        ->where('status', get_called_class()::STATUS_CREATION)
        ->first();

        if ($model) {
            return $model;
        }

        return get_called_class()::createEmptyModel();
    }

    protected static function createEmptyModel()
    {
        $called_class= get_called_class();
        $model = new $called_class;
        $model->created_by = auth()->user()->id;
        $model->status = $model::STATUS_CREATION;

        if ($model->canCreateEmpty) {
            $model->save();
        }

        if ($model->isTranstlatableModel()) {
            $translate_model = $model->getTranslatableModel();
            $translate_model->translatable_id = $model->id;
            $translate_model->created_by = auth()->user()->id;
            $translate_model->language = config('app.locale');
            $translate_model->status = $translate_model::STATUS_CREATION;
            $translate_model->save();
        }

        return $model;
    }

    public function loadDataFromCreateRequest(Request $request) : void
    {
        $create_attributes = $this->getModelAttributesFromCreateRules();
        $valid_attributes = $this->loadValidFieldsFromRequest($request, $create_attributes);

        $this->loadDataFromRequest($request, $valid_attributes);
    }

    public function loadDataFromRequest(Request $request, array $atributes) : void
    {
        if ($this->isTranstlatableModel()) {
            $translatable_model =  $this->getTranslatableModel();
            $this->assignValuesToModel(['identifier' => $request->input('identifier')], $this);
            unset($atributes['identifier']);
            $translatable_model = $this->assignValuesToModel($atributes, $translatable_model);
            $translatable_model->save();
        }
    }

    private function loadValidFieldsFromRequest(Request $request, array $attributes) : array
    {
        $valid_values = [];

        foreach ($request->all() as $attribute => $value) {
            if (in_array($attribute, $attributes)) {
                $valid_values[$attribute] = $value;
            }
        }

        return $valid_values;
    }

    private function assignValuesToModel(array $values, EloquentModel &$model ) : EloquentModel
    {
        foreach ($values as $attribute => $value) {
            $model->$attribute = $value;
        }

        return $model;
    }

    public function getApiEndpoint()
    {
        return strtolower(class_basename($this));
    }

    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function hasColumn($column)
    {
        if (in_array($column, $this->getTableColumns())) {
            return true;
        }

        return false;
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

    public static function findModel($id)
    {
        $class = get_called_class();
        $model = $class::where('id', $id)->first();

        if ($model) {
            return $model;
        }

        throw new APIException(['message' => __('base::responses.404')], 404);
    }

    // private function findModel

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
}
