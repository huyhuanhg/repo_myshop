<?php


use app\core\Model as DB;

class CategoryModel extends DB
{
    const __TABLE__ = 'categories';

    public function getAll()
    {
        $data = DB::table(self::__TABLE__)->get();
        return json_encode($this->fetchAssoc($data));
    }

    public function getById($id)
    {
        $category = DB::table(self::__TABLE__)->where('categoryID', '=', $id)->get();
        $category = $this->fetchAssoc($category);
        return json_encode(reset($category));
    }

    public function filter($key, $active = null)
    {
        if (!isset($active)) {
            $categories = DB::table(self::__TABLE__)->where('categoryID', 'LIKE', "$key%")->
            orWhere('category_title', 'LIKE', "%$key%")->get()->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $categoriesEqualID = DB::table(self::__TABLE__)->where('categoryID', 'LIKE', "$key%")
                ->where('category_active', '=', $active)->get()->fetchAll(PDO::FETCH_ASSOC);
            $categoriesSimilarName = DB::table(self::__TABLE__)->where('category_title', 'LIKE', "%$key%")
                ->where('category_active', '=', $active)->get()->fetchAll(PDO::FETCH_ASSOC);
            $categories = array_merge($categoriesEqualID, $categoriesSimilarName);
        }
        return $categories;
    }

    public function getMaxID()
    {
        $maxID = DB::table(self::__TABLE__)->select('MAX(categoryID) as maxID')->having('maxID', 'LIKE', 'DTDD-%')->get()->fetchAll(PDO::FETCH_ASSOC);
        $maxID = reset($maxID);
        if ($maxID['maxID'] === null) {
            return 0;
        } else {
            return explode('-', $maxID['maxID'])[1];
        }
    }

    public function insert($data)
    {
        return DB::table(self::__TABLE__)->insert($data);
    }


    public function delete($id)
    {
        //chú ý xóa category sẽ ảnh hưởng đến khóa ngoại
        /**
         * 1. product
            * 1.1 productImage
                * 1.1.1 file image của product
            * 1.2 product color
                * 1.2.1 file image của product color
            * 1.3 comment
            * 1.4 order detail
                * 1.4.1 orders
         */
        return DB::table(self::__TABLE__)->where('categoryID', '=', $id)->delete();
    }

    public function update($data)
    {
        $id = $data['categoryID'];
        unset($data['categoryID']);
        return DB::table(self::__TABLE__)->where('categoryID', '=', $id)->update($data);
    }
}
