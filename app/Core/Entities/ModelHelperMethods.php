<?php

namespace App\Core\Entities;

/**
 * Трейт-заглушка ТОЛЬКО для подсказок IDE (PhpStorm/Laravel Idea).
 * Никакого рантайм-кода здесь нет — все методы реально существуют
 * в Illuminate\Database\Eloquent\Builder / Illuminate\Database\Query\Builder / Model
 * и резолвятся через __call/__callStatic. Этот трейт лишь "объявляет" их
 * для статического анализа.
 *
 * Используй так:
 *
 *   abstract class AbstractEntity extends Model
 *   {
 *       use HasFactory;
 *       use ModelHelperMethods;
 *   }
 *
 * ---------------------------------------------------------------------
 * QUERY / RETRIEVING
 * ---------------------------------------------------------------------
 * @method static static|null find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Collection|static[] findMany($ids, $columns = ['*'])
 * @method static static findOrFail($id, $columns = ['*'])
 * @method static static findOrNew($id, $columns = ['*'])
 * @method static static firstOrNew(array $attributes = [], array $values = [])
 * @method static static firstOrCreate(array $attributes = [], array $values = [])
 * @method static static firstOrFail($columns = ['*'])
 * @method static static|mixed firstOr($columns = ['*'], \Closure $callback = null)
 * @method static static|null first($columns = ['*'])
 * @method static static sole($columns = ['*'])
 * @method static static updateOrCreate(array $attributes, array $values = [])
 * @method static static create(array $attributes = [])
 * @method static static forceCreate(array $attributes)
 * @method static static make(array $attributes = [])
 * @method static \Illuminate\Database\Eloquent\Collection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Collection|static[] all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Collection|static[] hydrate(array $items)
 * @method static \Illuminate\Support\LazyCollection cursor()
 * @method static \Illuminate\Support\LazyCollection lazy($chunkSize = 1000)
 * @method static \Illuminate\Support\LazyCollection lazyById($chunkSize = 1000, $column = null, $alias = null)
 * @method static \Illuminate\Support\LazyCollection lazyByIdDesc($chunkSize = 1000, $column = null, $alias = null)
 * @method static bool chunk($count, callable $callback)
 * @method static bool chunkById($count, callable $callback, $column = null, $alias = null)
 * @method static bool each(callable $callback, $count = 1000)
 * @method static \Illuminate\Contracts\Pagination\LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Contracts\Pagination\Paginator simplePaginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Contracts\Pagination\CursorPaginator cursorPaginate($perPage = null, $columns = ['*'], $cursorName = 'cursor', $cursor = null)
 *
 * ---------------------------------------------------------------------
 * COLUMNS / VALUES
 * ---------------------------------------------------------------------
 * @method static \Illuminate\Support\Collection pluck($column, $key = null)
 * @method static mixed value($column)
 * @method static mixed getModel()
 * @method static array pluckMany($columns)
 * @method static \Illuminate\Support\Collection|array toBase()
 *
 * ---------------------------------------------------------------------
 * WHERE / CONDITIONS
 * ---------------------------------------------------------------------
 * @method static \Illuminate\Database\Eloquent\Builder|static where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static orWhere($column, $operator = null, $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNot($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static whereColumn($first, $operator = null, $second = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNotIn($column, $values, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static orWhereIn($column, $values)
 * @method static \Illuminate\Database\Eloquent\Builder|static orWhereNotIn($column, $values)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNull($column, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNotNull($column, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static orWhereNull($column)
 * @method static \Illuminate\Database\Eloquent\Builder|static orWhereNotNull($column)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNotBetween($column, array $values, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static orWhereBetween($column, array $values)
 * @method static \Illuminate\Database\Eloquent\Builder|static orWhereNotBetween($column, array $values)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereDate($column, $operator, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static whereMonth($column, $operator, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static whereDay($column, $operator, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static whereYear($column, $operator, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static whereTime($column, $operator, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static whereJsonContains($column, $value, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereJsonLength($column, $operator, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static whereExists(\Closure $callback, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNotExists(\Closure $callback, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static whereRaw($sql, $bindings = [], $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static orWhereRaw($sql, $bindings = [])
 * @method static \Illuminate\Database\Eloquent\Builder|static whereHas($relation, \Closure $callback = null, $operator = '>=', $count = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|static orWhereHas($relation, \Closure $callback = null, $operator = '>=', $count = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereDoesntHave($relation, \Closure $callback = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static orWhereDoesntHave($relation, \Closure $callback = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereMorphedTo($relation, $model)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereBelongsTo($related, $relationshipName = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static withWhereHas($relation, \Closure $callback = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static when($value, callable $callback, callable $default = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static unless($value, callable $callback, callable $default = null)
 *
 * ---------------------------------------------------------------------
 * AGGREGATES
 * ---------------------------------------------------------------------
 * @method static int count($columns = '*')
 * @method static mixed min($column)
 * @method static mixed max($column)
 * @method static mixed sum($column)
 * @method static mixed avg($column)
 * @method static mixed average($column)
 * @method static bool exists()
 * @method static bool doesntExist()
 *
 * ---------------------------------------------------------------------
 * ORDER / GROUP / LIMIT
 * ---------------------------------------------------------------------
 * @method static \Illuminate\Database\Eloquent\Builder|static orderBy($column, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|static orderByDesc($column)
 * @method static \Illuminate\Database\Eloquent\Builder|static orderByRaw($sql, $bindings = [])
 * @method static \Illuminate\Database\Eloquent\Builder|static latest($column = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static oldest($column = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static inRandomOrder($seed = '')
 * @method static \Illuminate\Database\Eloquent\Builder|static reorder($column = null, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|static groupBy(...$groups)
 * @method static \Illuminate\Database\Eloquent\Builder|static groupByRaw($sql, array $bindings = [])
 * @method static \Illuminate\Database\Eloquent\Builder|static having($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static orHaving($column, $operator = null, $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static havingRaw($sql, array $bindings = [], $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|static limit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|static take($value)
 * @method static \Illuminate\Database\Eloquent\Builder|static offset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|static skip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|static forPage($page, $perPage = 15)
 *
 * ---------------------------------------------------------------------
 * SELECT / JOIN
 * ---------------------------------------------------------------------
 * @method static \Illuminate\Database\Eloquent\Builder|static select($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|static addSelect($column)
 * @method static \Illuminate\Database\Eloquent\Builder|static selectRaw($expression, array $bindings = [])
 * @method static \Illuminate\Database\Eloquent\Builder|static distinct($column = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static join($table, $first, $operator = null, $second = null, $type = 'inner', $where = false)
 * @method static \Illuminate\Database\Eloquent\Builder|static leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static crossJoin($table, $first = null, $operator = null, $second = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static from($table, $as = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static union($query, $all = false)
 * @method static \Illuminate\Database\Eloquent\Builder|static unionAll($query)
 *
 * ---------------------------------------------------------------------
 * RELATIONS / EAGER LOADING
 * ---------------------------------------------------------------------
 * @method static \Illuminate\Database\Eloquent\Builder|static with($relations)
 * @method static \Illuminate\Database\Eloquent\Builder|static without($relations)
 * @method static \Illuminate\Database\Eloquent\Builder|static withOnly($relations)
 * @method static \Illuminate\Database\Eloquent\Builder|static withCount($relations)
 * @method static \Illuminate\Database\Eloquent\Builder|static withSum($relation, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|static withAvg($relation, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|static withMin($relation, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|static withMax($relation, $column)
 * @method static \Illuminate\Database\Eloquent\Builder|static withExists($relation)
 * @method \Illuminate\Database\Eloquent\Relations\HasOne hasOne($related, $foreignKey = null, $localKey = null)
 * @method \Illuminate\Database\Eloquent\Relations\HasMany hasMany($related, $foreignKey = null, $localKey = null)
 * @method \Illuminate\Database\Eloquent\Relations\HasManyThrough hasManyThrough($related, $through, $firstKey = null, $secondKey = null, $localKey = null, $secondLocalKey = null)
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo belongsTo($related, $foreignKey = null, $ownerKey = null, $relation = null)
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany belongsToMany($related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null, $parentKey = null, $relatedKey = null, $relation = null)
 * @method \Illuminate\Database\Eloquent\Relations\MorphOne morphOne($related, $name, $type = null, $id = null, $localKey = null)
 * @method \Illuminate\Database\Eloquent\Relations\MorphMany morphMany($related, $name, $type = null, $id = null, $localKey = null)
 * @method \Illuminate\Database\Eloquent\Relations\MorphTo morphTo($name = null, $type = null, $id = null, $ownerKey = null)
 * @method \Illuminate\Database\Eloquent\Relations\MorphToMany morphToMany($related, $name, $table = null, $foreignPivotKey = null, $relatedPivotKey = null, $parentKey = null, $relatedKey = null, $inverse = false)
 *
 * ---------------------------------------------------------------------
 * UPDATE / DELETE / SAVE
 * ---------------------------------------------------------------------
 * @method bool save(array $options = [])
 * @method bool saveQuietly(array $options = [])
 * @method bool push()
 * @method bool update(array $attributes = [], array $options = [])
 * @method static int updateAll(array $values)
 * @method bool delete()
 * @method bool deleteQuietly()
 * @method bool forceDelete()
 * @method static int destroy($ids)
 * @method static bool truncate()
 * @method bool restore()
 * @method bool trashed()
 * @method static \Illuminate\Database\Eloquent\Builder|static onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|static withTrashed($withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder|static withoutTrashed()
 * @method bool fill(array $attributes)
 * @method bool forceFill(array $attributes)
 * @method bool touch()
 * @method $this fresh($with = [])
 * @method $this refresh()
 * @method $this replicate(array $except = null)
 * @method bool is($model)
 * @method bool isNot($model)
 * @method array toArray()
 * @method string toJson($options = 0)
 * @method array attributesToArray()
 * @method mixed getAttribute($key)
 * @method $this setAttribute($key, $value)
 * @method array getAttributes()
 * @method array getDirty()
 * @method array getChanges()
 * @method bool isDirty($attributes = null)
 * @method bool isClean($attributes = null)
 * @method bool wasChanged($attributes = null)
 * @method mixed getKey()
 * @method string getKeyName()
 * @method string getTable()
 * @method $this setTable($table)
 *
 * ---------------------------------------------------------------------
 * LOCKING / MISC
 * ---------------------------------------------------------------------
 * @method static \Illuminate\Database\Eloquent\Builder|static lockForUpdate()
 * @method static \Illuminate\Database\Eloquent\Builder|static sharedLock()
 * @method static \Illuminate\Database\Eloquent\Builder|static withoutGlobalScope($scope)
 * @method static \Illuminate\Database\Eloquent\Builder|static withoutGlobalScopes(array $scopes = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static tap($callback)
 * @method static \Illuminate\Database\Eloquent\Builder|static newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|static newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|static query()
 * @method static \Illuminate\Database\Eloquent\Builder|static on($connection = null)
 * @method static \Illuminate\Database\Eloquent\Builder|static onWriteConnection()
 * @method static \Database\Factories\Factory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|static raw($value)
 */
trait ModelHelperMethods
{
    //
}
