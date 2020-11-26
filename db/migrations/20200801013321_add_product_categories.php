<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddProductCategories extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $productCategories = [
                [
                    'id'          => 1,
                    'category_id' => 2,
                    'product_id'  => 1,
                ],
                [
                    'id'          => 2,
                    'category_id' => 1,
                    'product_id'  => 2,
                ],
                [
                    'id'          => 3,
                    'category_id' => 1,
                    'product_id'  => 3,
                ],
                [
                    'id'          => 4,
                    'category_id' => 1,
                    'product_id'  => 4,
                ],
                [
                    'id'          => 5,
                    'category_id' => 1,
                    'product_id'  => 5,
                ],
                [
                    'id'          => 6,
                    'category_id' => 1,
                    'product_id'  => 6,
                ],
                [
                    'id'          => 7,
                    'category_id' => 1,
                    'product_id'  => 7,
                ],
                [
                    'id'          => 8,
                    'category_id' => 1,
                    'product_id'  => 8,
                ],
                [
                    'id'          => 9,
                    'category_id' => 1,
                    'product_id'  => 9,
                ],
                [
                    'id'          => 10,
                    'category_id' => 1,
                    'product_id'  => 10,
                ],
                [
                    'id'          => 11,
                    'category_id' => 1,
                    'product_id'  => 11,
                ],
                [
                    'id'          => 12,
                    'category_id' => 2,
                    'product_id'  => 12,
                ],
                [
                    'id'          => 13,
                    'category_id' => 1,
                    'product_id'  => 13,
                ],
                [
                    'id'          => 14,
                    'category_id' => 1,
                    'product_id'  => 14,
                ],
                [
                    'id'          => 15,
                    'category_id' => 2,
                    'product_id'  => 15,
                ],
                [
                    'id'          => 16,
                    'category_id' => 1,
                    'product_id'  => 16,
                ],
                [
                    'id'          => 17,
                    'category_id' => 2,
                    'product_id'  => 17,
                ],
                [
                    'id'          => 18,
                    'category_id' => 2,
                    'product_id'  => 18,
                ],
                [
                    'id'          => 19,
                    'category_id' => 2,
                    'product_id'  => 19,
                ],
                [
                    'id'          => 20,
                    'category_id' => 2,
                    'product_id'  => 20,
                ],
                [
                    'id'          => 21,
                    'category_id' => 2,
                    'product_id'  => 21,
                ],
                [
                    'id'          => 22,
                    'category_id' => 2,
                    'product_id'  => 22,
                ],
                [
                    'id'          => 23,
                    'category_id' => 2,
                    'product_id'  => 23,
                ],
                [
                    'id'          => 24,
                    'category_id' => 2,
                    'product_id'  => 24,
                ],
                [
                    'id'          => 25,
                    'category_id' => 2,
                    'product_id'  => 25,
                ],
                [
                    'id'          => 26,
                    'category_id' => 2,
                    'product_id'  => 26,
                ],
                [
                    'id'          => 27,
                    'category_id' => 2,
                    'product_id'  => 27,
                ],
                [
                    'id'          => 28,
                    'category_id' => 1,
                    'product_id'  => 28,
                ],
                [
                    'id'          => 29,
                    'category_id' => 1,
                    'product_id'  => 29,
                ],
                [
                    'id'          => 30,
                    'category_id' => 1,
                    'product_id'  => 30,
                ],
                [
                    'id'          => 31,
                    'category_id' => 2,
                    'product_id'  => 31,
                ],
                [
                    'id'          => 32,
                    'category_id' => 1,
                    'product_id'  => 32,
                ],
                [
                    'id'          => 33,
                    'category_id' => 2,
                    'product_id'  => 33,
                ],
                [
                    'id'          => 34,
                    'category_id' => 2,
                    'product_id'  => 34,
                ],
                [
                    'id'          => 35,
                    'category_id' => 3,
                    'product_id'  => 85,
                ],
                [
                    'id'          => 36,
                    'category_id' => 3,
                    'product_id'  => 86,
                ],
                [
                    'id'          => 40,
                    'category_id' => 2,
                    'product_id'  => 40,
                ],
                [
                    'id'          => 41,
                    'category_id' => 2,
                    'product_id'  => 41,
                ],
                [
                    'id'          => 42,
                    'category_id' => 2,
                    'product_id'  => 42,
                ],
                [
                    'id'          => 43,
                    'category_id' => 2,
                    'product_id'  => 43,
                ],
                [
                    'id'          => 44,
                    'category_id' => 2,
                    'product_id'  => 44,
                ],
                [
                    'id'          => 45,
                    'category_id' => 2,
                    'product_id'  => 45,
                ],
                [
                    'id'          => 46,
                    'category_id' => 1,
                    'product_id'  => 46,
                ],
                [
                    'id'          => 47,
                    'category_id' => 1,
                    'product_id'  => 47,
                ],
                [
                    'id'          => 48,
                    'category_id' => 1,
                    'product_id'  => 48,
                ],
                [
                    'id'          => 49,
                    'category_id' => 1,
                    'product_id'  => 49,
                ],
                [
                    'id'          => 50,
                    'category_id' => 1,
                    'product_id'  => 50,
                ],
                [
                    'id'          => 51,
                    'category_id' => 1,
                    'product_id'  => 51,
                ],
                [
                    'id'          => 52,
                    'category_id' => 1,
                    'product_id'  => 52,
                ],
                [
                    'id'          => 53,
                    'category_id' => 1,
                    'product_id'  => 53,
                ],
                [
                    'id'          => 54,
                    'category_id' => 1,
                    'product_id'  => 54,
                ],
                [
                    'id'          => 55,
                    'category_id' => 1,
                    'product_id'  => 55,
                ],
                [
                    'id'          => 56,
                    'category_id' => 1,
                    'product_id'  => 56,
                ],
                [
                    'id'          => 57,
                    'category_id' => 1,
                    'product_id'  => 57,
                ],
                [
                    'id'          => 58,
                    'category_id' => 1,
                    'product_id'  => 58,
                ],
                [
                    'id'          => 59,
                    'category_id' => 2,
                    'product_id'  => 59,
                ],
                [
                    'id'          => 60,
                    'category_id' => 2,
                    'product_id'  => 60,
                ],
                [
                    'id'          => 61,
                    'category_id' => 1,
                    'product_id'  => 61,
                ],
                [
                    'id'          => 62,
                    'category_id' => 1,
                    'product_id'  => 62,
                ],
                [
                    'id'          => 63,
                    'category_id' => 2,
                    'product_id'  => 63,
                ],
                [
                    'id'          => 65,
                    'category_id' => 1,
                    'product_id'  => 65,
                ],
                [
                    'id'          => 66,
                    'category_id' => 1,
                    'product_id'  => 66,
                ],
                [
                    'id'          => 67,
                    'category_id' => 1,
                    'product_id'  => 67,
                ],
                [
                    'id'          => 68,
                    'category_id' => 2,
                    'product_id'  => 68,
                ],
                [
                    'id'          => 69,
                    'category_id' => 2,
                    'product_id'  => 69,
                ],
                [
                    'id'          => 70,
                    'category_id' => 2,
                    'product_id'  => 70,
                ],
                [
                    'id'          => 71,
                    'category_id' => 2,
                    'product_id'  => 71,
                ],
                [
                    'id'          => 72,
                    'category_id' => 2,
                    'product_id'  => 72,
                ],
                [
                    'id'          => 73,
                    'category_id' => 2,
                    'product_id'  => 73,
                ],
                [
                    'id'          => 74,
                    'category_id' => 1,
                    'product_id'  => 74,
                ],
                [
                    'id'          => 75,
                    'category_id' => 2,
                    'product_id'  => 75,
                ],
                [
                    'id'          => 76,
                    'category_id' => 2,
                    'product_id'  => 76,
                ],
                [
                    'id'          => 77,
                    'category_id' => 2,
                    'product_id'  => 77,
                ],
                [
                    'id'          => 78,
                    'category_id' => 2,
                    'product_id'  => 78,
                ],
                [
                    'id'          => 79,
                    'category_id' => 2,
                    'product_id'  => 79,
                ],
                [
                    'id'          => 80,
                    'category_id' => 2,
                    'product_id'  => 80,
                ],
                [
                    'id'          => 81,
                    'category_id' => 2,
                    'product_id'  => 81,
                ],
                [
                    'id'          => 82,
                    'category_id' => 2,
                    'product_id'  => 82,
                ],
                [
                    'id'          => 83,
                    'category_id' => 2,
                    'product_id'  => 83,
                ],
                [
                    'id'          => 84,
                    'category_id' => 2,
                    'product_id'  => 84,
                ],
                [
                    'id'          => 103,
                    'category_id' => 3,
                    'product_id'  => 35,
                ],
                [
                    'id'          => 104,
                    'category_id' => 3,
                    'product_id'  => 36,
                ],
                [
                    'id'          => 105,
                    'category_id' => 3,
                    'product_id'  => 37,
                ],
                [
                    'id'          => 106,
                    'category_id' => 3,
                    'product_id'  => 38,
                ],
                [
                    'id'          => 108,
                    'category_id' => 3,
                    'product_id'  => 47,
                ],
                [
                    'id'          => 111,
                    'category_id' => 2,
                    'product_id'  => 2,
                ],
                [
                    'id'          => 112,
                    'category_id' => 2,
                    'product_id'  => 3,
                ],
                [
                    'id'          => 113,
                    'category_id' => 2,
                    'product_id'  => 4,
                ],
                [
                    'id'          => 114,
                    'category_id' => 2,
                    'product_id'  => 5,
                ],
                [
                    'id'          => 115,
                    'category_id' => 2,
                    'product_id'  => 6,
                ],
                [
                    'id'          => 116,
                    'category_id' => 2,
                    'product_id'  => 7,
                ],
                [
                    'id'          => 117,
                    'category_id' => 2,
                    'product_id'  => 14,
                ],
                [
                    'id'          => 118,
                    'category_id' => 2,
                    'product_id'  => 16,
                ],
                [
                    'id'          => 119,
                    'category_id' => 1,
                    'product_id'  => 18,
                ],
                [
                    'id'          => 120,
                    'category_id' => 1,
                    'product_id'  => 19,
                ],
                [
                    'id'          => 121,
                    'category_id' => 2,
                    'product_id'  => 29,
                ],
                [
                    'id'          => 122,
                    'category_id' => 2,
                    'product_id'  => 30,
                ],
                [
                    'id'          => 123,
                    'category_id' => 2,
                    'product_id'  => 46,
                ],
                [
                    'id'          => 124,
                    'category_id' => 2,
                    'product_id'  => 47,
                ],
                [
                    'id'          => 125,
                    'category_id' => 2,
                    'product_id'  => 48,
                ],
                [
                    'id'          => 126,
                    'category_id' => 2,
                    'product_id'  => 49,
                ],
                [
                    'id'          => 127,
                    'category_id' => 2,
                    'product_id'  => 61,
                ],
                [
                    'id'          => 128,
                    'category_id' => 2,
                    'product_id'  => 62,
                ],
                [
                    'id'          => 129,
                    'category_id' => 2,
                    'product_id'  => 55,
                ],
                [
                    'id'          => 130,
                    'category_id' => 2,
                    'product_id'  => 65,
                ],
                [
                    'id'          => 131,
                    'category_id' => 2,
                    'product_id'  => 66,
                ],
                [
                    'id'          => 132,
                    'category_id' => 4,
                    'product_id'  => 35,
                ],
                [
                    'id'          => 133,
                    'category_id' => 4,
                    'product_id'  => 36,
                ],
                [
                    'id'          => 134,
                    'category_id' => 4,
                    'product_id'  => 37,
                ],
                [
                    'id'          => 135,
                    'category_id' => 4,
                    'product_id'  => 38,
                ],
                [
                    'id'          => 136,
                    'category_id' => 4,
                    'product_id'  => 85,
                ],
                [
                    'id'          => 137,
                    'category_id' => 4,
                    'product_id'  => 86,
                ],
                [
                    'id'          => 138,
                    'category_id' => 4,
                    'product_id'  => 29,
                ],
                [
                    'id'          => 139,
                    'category_id' => 4,
                    'product_id'  => 46,
                ],
                [
                    'id'          => 140,
                    'category_id' => 4,
                    'product_id'  => 10,
                ],
                [
                    'id'          => 141,
                    'category_id' => 4,
                    'product_id'  => 61,
                ],
                [
                    'id'          => 142,
                    'category_id' => 5,
                    'product_id'  => 98,
                ],
                [
                    'id'          => 143,
                    'category_id' => 5,
                    'product_id'  => 99,
                ],
                [
                    'id'          => 144,
                    'category_id' => 5,
                    'product_id'  => 100,
                ],
                [
                    'id'          => 145,
                    'category_id' => 5,
                    'product_id'  => 2,
                ],
                [
                    'id'          => 146,
                    'category_id' => 5,
                    'product_id'  => 3,
                ],
                [
                    'id'          => 147,
                    'category_id' => 4,
                    'product_id'  => 48,
                ],
                [
                    'id'          => 148,
                    'category_id' => 5,
                    'product_id'  => 30,
                ],
                [
                    'id'          => 149,
                    'category_id' => 5,
                    'product_id'  => 62,
                ],
                [
                    'id'          => 150,
                    'category_id' => 4,
                    'product_id'  => 66,
                ],
                [
                    'id'          => 151,
                    'category_id' => 1,
                    'product_id'  => 104,
                ],
                [
                    'id'          => 152,
                    'category_id' => 2,
                    'product_id'  => 104,
                ],
                [
                    'id'          => 153,
                    'category_id' => 4,
                    'product_id'  => 104,
                ],
                [
                    'id'          => 154,
                    'category_id' => 5,
                    'product_id'  => 65,
                ],
                [
                    'id'          => 155,
                    'category_id' => 1,
                    'product_id'  => 39,
                ],
                [
                    'id'          => 156,
                    'category_id' => 2,
                    'product_id'  => 39,
                ],
                [
                    'id'          => 157,
                    'category_id' => 1,
                    'product_id'  => 64,
                ],
                [
                    'id'          => 158,
                    'category_id' => 1,
                    'product_id'  => 87,
                ],
                [
                    'id'          => 159,
                    'category_id' => 2,
                    'product_id'  => 87,
                ],
                [
                    'id'          => 160,
                    'category_id' => 1,
                    'product_id'  => 88,
                ],
                [
                    'id'          => 161,
                    'category_id' => 2,
                    'product_id'  => 88,
                ],
                [
                    'id'          => 162,
                    'category_id' => 1,
                    'product_id'  => 89,
                ],
                [
                    'id'          => 163,
                    'category_id' => 2,
                    'product_id'  => 89,
                ],
                [
                    'id'          => 164,
                    'category_id' => 1,
                    'product_id'  => 90,
                ],
                [
                    'id'          => 165,
                    'category_id' => 2,
                    'product_id'  => 90,
                ],
                [
                    'id'          => 166,
                    'category_id' => 1,
                    'product_id'  => 91,
                ],
                [
                    'id'          => 167,
                    'category_id' => 2,
                    'product_id'  => 91,
                ],
                [
                    'id'          => 168,
                    'category_id' => 1,
                    'product_id'  => 92,
                ],
                [
                    'id'          => 169,
                    'category_id' => 2,
                    'product_id'  => 92,
                ],
                [
                    'id'          => 170,
                    'category_id' => 1,
                    'product_id'  => 93,
                ],
                [
                    'id'          => 171,
                    'category_id' => 2,
                    'product_id'  => 93,
                ],
                [
                    'id'          => 172,
                    'category_id' => 1,
                    'product_id'  => 94,
                ],
                [
                    'id'          => 173,
                    'category_id' => 2,
                    'product_id'  => 94,
                ],
                [
                    'id'          => 174,
                    'category_id' => 1,
                    'product_id'  => 95,
                ],
                [
                    'id'          => 175,
                    'category_id' => 2,
                    'product_id'  => 95,
                ],
                [
                    'id'          => 176,
                    'category_id' => 1,
                    'product_id'  => 96,
                ],
                [
                    'id'          => 177,
                    'category_id' => 2,
                    'product_id'  => 96,
                ],
                [
                    'id'          => 178,
                    'category_id' => 1,
                    'product_id'  => 97,
                ],
                [
                    'id'          => 179,
                    'category_id' => 2,
                    'product_id'  => 97,
                ],
                [
                    'id'          => 180,
                    'category_id' => 1,
                    'product_id'  => 52,
                ],
                [
                    'id'          => 181,
                    'category_id' => 2,
                    'product_id'  => 52,
                ],
                [
                    'id'          => 182,
                    'category_id' => 1,
                    'product_id'  => 53,
                ],
                [
                    'id'          => 183,
                    'category_id' => 2,
                    'product_id'  => 53,
                ],
                [
                    'id'          => 184,
                    'category_id' => 1,
                    'product_id'  => 101,
                ],
                [
                    'id'          => 185,
                    'category_id' => 2,
                    'product_id'  => 101,
                ],
                [
                    'id'          => 186,
                    'category_id' => 1,
                    'product_id'  => 102,
                ],
                [
                    'id'          => 187,
                    'category_id' => 2,
                    'product_id'  => 102,
                ],
                [
                    'id'          => 188,
                    'category_id' => 1,
                    'product_id'  => 103,
                ],
                [
                    'id'          => 189,
                    'category_id' => 2,
                    'product_id'  => 103,
                ],
                [
                    'id'          => 191,
                    'category_id' => 1,
                    'product_id'  => 105,
                ],
                [
                    'id'          => 192,
                    'category_id' => 2,
                    'product_id'  => 105,
                ],
                [
                    'id'          => 193,
                    'category_id' => 2,
                    'product_id'  => 74,
                ],
                [
                    'id'          => 194,
                    'category_id' => 2,
                    'product_id'  => 106,
                ],
                [
                    'id'          => 195,
                    'category_id' => 2,
                    'product_id'  => 8,
                ],
                [
                    'id'          => 196,
                    'category_id' => 2,
                    'product_id'  => 10,
                ],
                [
                    'id'          => 197,
                    'category_id' => 2,
                    'product_id'  => 50,
                ],
                [
                    'id'          => 198,
                    'category_id' => 2,
                    'product_id'  => 58,
                ],
                [
                    'id'          => 199,
                    'category_id' => 2,
                    'product_id'  => 54,
                ],
                [
                    'id'          => 200,
                    'category_id' => 1,
                    'product_id'  => 107,
                ],
                [
                    'id'          => 201,
                    'category_id' => 2,
                    'product_id'  => 107,
                ],
                [
                    'id'          => 202,
                    'category_id' => 2,
                    'product_id'  => 11,
                ],
                [
                    'id'          => 203,
                    'category_id' => 2,
                    'product_id'  => 67,
                ],
                [
                    'id'          => 204,
                    'category_id' => 2,
                    'product_id'  => 51,
                ],
                [
                    'id'          => 205,
                    'category_id' => 1,
                    'product_id'  => 59,
                ],
                [
                    'id'          => 206,
                    'category_id' => 2,
                    'product_id'  => 28,
                ],
                [
                    'id'          => 207,
                    'category_id' => 2,
                    'product_id'  => 13,
                ],
                [
                    'id'          => 208,
                    'category_id' => 2,
                    'product_id'  => 9,
                ],
        ];
        $this->table('product_categories')->insert($productCategories)->save();
    }
}
