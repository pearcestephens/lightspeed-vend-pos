<?php

namespace App\Repositories;

use App\Models\59;
use Illuminate\Database\Eloquent\Collection;

class 59Repository {

    public function findById($id): ?59 {
        return 59::find($id);
    }

    public function getAll(): Collection {
        return 59::all();
    }

    public function create(array $data): 59 {
        return 59::create($data);
    }

    public function update($id, array $data): bool {
        return 59::find($id)->update($data);
    }

    public function delete($id): bool {
        return 59::destroy($id) > 0;
    }
}