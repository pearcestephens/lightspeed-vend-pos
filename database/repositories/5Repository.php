<?php

namespace App\Repositories;

use App\Models\5;
use Illuminate\Database\Eloquent\Collection;

class 5Repository {

    public function findById($id): ?5 {
        return 5::find($id);
    }

    public function getAll(): Collection {
        return 5::all();
    }

    public function create(array $data): 5 {
        return 5::create($data);
    }

    public function update($id, array $data): bool {
        return 5::find($id)->update($data);
    }

    public function delete($id): bool {
        return 5::destroy($id) > 0;
    }
}