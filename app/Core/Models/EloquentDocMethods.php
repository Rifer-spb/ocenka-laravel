<?php

namespace App\Core\Models;

/**
 * Методы сформированы в ИИ по классу Illuminate\Database\Eloquent\Builder
 *
 * @method static static newModelQuery()
 * @method static static newQuery()
 * @method static static query()
 * @method static static withGlobalScope($identifier, $scope)
 * @method static static withoutGlobalScope($scope)
 * @method static static withoutGlobalScopes(?array $scopes = null)
 * @method static static withoutGlobalScopesExcept(array $scopes = [])
 * @method static static whereKey($id)
 * @method static static whereKeyNot($id)
 * @method static static except($models)
 * @method static static where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static static orWhere($column, $operator = null, $value = null)
 * @method static static whereNot($column, $operator = null, $value = null, $boolean = 'and')
 * @method static static orWhereNot($column, $operator = null, $value = null)
 * @method static static latest($column = null)
 * @method static static oldest($column = null)
 * @method static static afterQuery(\Closure $callback)
 * @method static static with($relations, $callback = null)
 * @method static static without($relations)
 * @method static static withOnly($relations)
 * @method static static withAttributes($attributes, $value = null, $asConditions = true)
 * @method static static withCasts($casts)
 * @method static static setEagerLoads(array $eagerLoad)
 * @method static static withoutEagerLoad(array $relations)
 * @method static static withoutEagerLoads()
 * @method static static scopes($scopes)
 * @method static static onDelete(\Closure $callback)
 * @method static static onClone(\Closure $callback)
 *
 * // Find methods
 * @method static static|null find($id, $columns = ['*'])
 * @method static static findOrFail($id, $columns = ['*'])
 * @method static static findSole($id, $columns = ['*'])
 * @method static static findOrNew($id, $columns = ['*'])
 * @method static static|mixed findOr($id, $columns = ['*'], ?\Closure $callback = null)
 * @method static static first($columns = ['*'])
 * @method static static firstOrFail($columns = ['*'])
 * @method static static|mixed firstOr($columns = ['*'], ?\Closure $callback = null)
 * @method static static|null firstWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method static static sole($columns = ['*'])
 * @method static static firstOrNew(array $attributes = [], array $values = [])
 * @method static static firstOrCreate(array $attributes = [], array $values = [])
 * @method static static createOrFirst(array $attributes = [], array $values = [])
 * @method static static updateOrCreate(array $attributes, array $values = [])
 * @method static static incrementOrCreate(array $attributes, string $column = 'count', $default = 1, $step = 1, array $extra = [])
 *
 * // Create methods
 * @method static static make(array $attributes = [])
 * @method static static create(array $attributes = [])
 * @method static static createQuietly(array $attributes = [])
 * @method static static forceCreate(array $attributes)
 * @method static static forceCreateQuietly(array $attributes = [])
 * @method static static newModelInstance($attributes = [])
 *
 * // Collection methods
 * @method static \Illuminate\Database\Eloquent\Collection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Collection|static[] getModels($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Collection|static[] findMany($ids, $columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Collection|static[] hydrate(array $items)
 * @method static \Illuminate\Database\Eloquent\Collection|static[] fromQuery($query, $bindings = [])
 * @method static \Illuminate\Support\Collection pluck($column, $key = null)
 * @method static \Illuminate\Support\LazyCollection cursor()
 *
 * // Aggregate methods
 * @method static int count($columns = '*')
 * @method static mixed sum($column)
 * @method static mixed avg($column)
 * @method static mixed average($column)
 * @method static mixed min($column)
 * @method static mixed max($column)
 * @method static mixed value($column)
 * @method static mixed soleValue($column)
 * @method static mixed valueOrFail($column)
 * @method static bool exists()
 * @method static bool doesntExist()
 *
 * // Update/Delete methods
 * @method static int update(array $values)
 * @method static int upsert(array $values, $uniqueBy, $update = null)
 * @method static int|false touch($column = null)
 * @method static int increment($column, $amount = 1, array $extra = [])
 * @method static int decrement($column, $amount = 1, array $extra = [])
 * @method static mixed delete()
 * @method static mixed forceDelete()
 * @method static bool insert(array $values)
 * @method static int insertGetId(array $values, $sequence = null)
 * @method static int insertOrIgnore(array $values)
 * @method static bool fillAndInsert(array $values)
 * @method static int fillAndInsertOrIgnore(array $values)
 * @method static int fillAndInsertGetId(array $values)
 *
 * // Pagination methods
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null, $total = null)
 * @method static \Illuminate\Contracts\Pagination\Paginator simplePaginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Contracts\Pagination\CursorPaginator cursorPaginate($perPage = null, $columns = ['*'], $cursorName = 'cursor', $cursor = null)
 *
 * // Order methods
 * @method static static orderBy($column, $direction = 'asc')
 * @method static static orderByDesc($column)
 * @method static static inRandomOrder()
 * @method static static reorder($column = null, $direction = 'asc')
 *
 * // Limit methods
 * @method static static limit($value)
 * @method static static offset($value)
 * @method static static take($value)
 * @method static static skip($value)
 * @method static static forPage($page, $perPage = 15)
 *
 * // Group methods
 * @method static static groupBy($groups)
 * @method static static having($column, $operator = null, $value = null)
 * @method static static havingRaw($sql, $bindings = [])
 * @method static static orHaving($column, $operator = null, $value = null)
 *
 * // Join methods
 * @method static static join($table, $first, $operator = null, $second = null, $type = 'inner')
 * @method static static joinWhere($table, $first, $operator, $second, $type = 'inner')
 * @method static static leftJoin($table, $first, $operator = null, $second = null)
 * @method static static rightJoin($table, $first, $operator = null, $second = null)
 * @method static static crossJoin($table, $first = null, $operator = null, $second = null)
 *
 * // Where methods (continued)
 * @method static static whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static static whereNotIn($column, $values, $boolean = 'and')
 * @method static static whereBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static static whereNotBetween($column, array $values, $boolean = 'and')
 * @method static static whereNull($column, $boolean = 'and', $not = false)
 * @method static static whereNotNull($column, $boolean = 'and')
 * @method static static whereDate($column, $operator, $value = null, $boolean = 'and')
 * @method static static whereMonth($column, $operator, $value = null, $boolean = 'and')
 * @method static static whereDay($column, $operator, $value = null, $boolean = 'and')
 * @method static static whereYear($column, $operator, $value = null, $boolean = 'and')
 * @method static static whereTime($column, $operator, $value = null, $boolean = 'and')
 * @method static static whereColumn($first, $operator = null, $second = null, $boolean = 'and')
 * @method static static whereRaw($sql, $bindings = [], $boolean = 'and')
 * @method static static orWhereRaw($sql, $bindings = [])
 *
 * // Relationship methods
 * @method static static has($relation, $operator = '>=', $count = 1, $boolean = 'and', \Closure $callback = null)
 * @method static static orHas($relation, $operator = '>=', $count = 1)
 * @method static static doesntHave($relation, $boolean = 'and', \Closure $callback = null)
 * @method static static whereHas($relation, \Closure $callback = null, $operator = '>=', $count = 1)
 * @method static static whereDoesntHave($relation, \Closure $callback = null)
 * @method static static withWhereHas($relation, \Closure $callback = null)
 *
 * // Chunk methods
 * @method static bool chunk($count, \Closure $callback)
 * @method static \Illuminate\Support\Collection chunkMap(\Closure $callback, $count = 1000)
 * @method static \Illuminate\Support\LazyCollection lazy($chunkSize = 1000)
 * @method static void each(\Closure $callback, $count = 1000)
 *
 * // Soft delete methods
 * @method static static onlyTrashed()
 * @method static static withTrashed()
 * @method static static withoutTrashed()
 *
 * // Lock methods
 * @method static static lock($value = true)
 * @method static static lockForUpdate()
 * @method static static sharedLock()
 *
 * // Query builder passthru methods
 * @method static mixed dd()
 * @method static mixed dump()
 * @method static string toSql()
 * @method static array getBindings()
 * @method static \Illuminate\Database\Connection getConnection()
 * @method static \Illuminate\Database\Query\Grammars\Grammar getGrammar()
 * @method static \Illuminate\Database\Query\Builder useWritePdo()
 * @method static \Illuminate\Database\Query\Builder select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder selectRaw($expression, array $bindings = [])
 * @method static \Illuminate\Database\Query\Builder distinct()
 * @method static \Illuminate\Database\Query\Builder from($table, $as = null)
 * @method static \Illuminate\Database\Query\Builder addSelect($column)
 * @method static \Illuminate\Database\Query\Builder union($query, $all = false)
 * @method static \Illuminate\Database\Query\Builder unionAll($query)
 * @method static static when($value, callable $callback, callable $default = null)
 * @method static static unless($value, callable $callback, callable $default = null)
 * @method static static tap(callable $callback)
 */
trait EloquentDocMethods {}
