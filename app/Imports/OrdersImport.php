<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OrdersImport implements ToCollection, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param Collection $collection
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if ($this->getCategoryId($row[0])) {
                $user = User::query()->withoutTrashed()
                    ->where(['phone' => $row[2], 'email' => $row[3]])
                    ->orWhere('phone', $row[2])
                    ->orWhere('email', $row[3])
                    ->firstOr(function () use ($row) {
                        return User::create([
                            'phone' => $row[2],
                            'email' => $row[3],
                            'country_id' => Country::first()->id,
                            'name' => $row[1],
                            'type' => User::PATIENT
                        ]);
                    });

                $user->update(['phone' => $row[2], 'email' => $row[3]]);

                Order::create([
                    'category_id' => $this->getCategoryId($row[0]),
                    'branch_id' => 1,
                    'source_id' => 15,
                    'user_id' => $user->id,
                    'status_id' => Order::NEW
                ]);
            }
        }
    }

    private function getCategoryId($category_name)
    {
        $category = Category::whereTranslationLike('name', "%$category_name%")->first();

        if ($category != null) {
            return $category->id;
        }

        return false;
    }
}