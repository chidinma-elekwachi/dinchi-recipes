<?php
require_once __DIR__ . '/../config/config.php';

class DB {
  public static function manager() {
    static $manager = null;
    if ($manager === null) {
      $uri = env('MONGO_URI');
      $manager = new MongoDB\Driver\Manager($uri);
    }
    return $manager;
  }

  public static function dbName() {
    return env('MONGO_DB');
  }

  public static function insert($collection, $doc) {
    $bulk = new MongoDB\Driver\BulkWrite;
    $doc['_id'] = $doc['_id'] ?? new MongoDB\BSON\ObjectId;
    $bulk->insert($doc);
    $result = self::manager()->executeBulkWrite(self::dbName().'.'.$collection, $bulk);
    return $doc;
  }

  public static function findOne($collection, $filter) {
    $query = new MongoDB\Driver\Query($filter, ['limit'=>1]);
    $cursor = self::manager()->executeQuery(self::dbName().'.'.$collection, $query);
    foreach ($cursor as $doc) return json_decode(json_encode($doc), true);
    return null;
  }

  public static function updateOne($collection, $filter, $update) {
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->update($filter, $update, ['multi'=>false, 'upsert'=>false]);
    $result = self::manager()->executeBulkWrite(self::dbName().'.'.$collection, $bulk);
    return $result;
  }

  public static function find($collection, $filter=[], $options=[]) {
    $query = new MongoDB\Driver\Query($filter, $options);
    $cursor = self::manager()->executeQuery(self::dbName().'.'.$collection, $query);
    $out = [];
    foreach ($cursor as $doc) $out[] = json_decode(json_encode($doc), true);
    return $out;
  }
}