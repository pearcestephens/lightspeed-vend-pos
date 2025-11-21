<?php

namespace App\Repositories;

use App\Models\66;
use Illuminate\Database\Eloquent\Collection;

class 66Repository {

    public function findById($id): ?66 {
        return 66::find($id);
    }

    public function getAll(): Collection {
        return 66::all();
    }

    public function create(array $data): 66 {
        return 66::create($data);
    }

    public function update($id, array $data): bool {
        return 66::find($id)->update($data);
    }

    public function delete($id): bool {
        return 66::destroy($id) > 0;
    }
}