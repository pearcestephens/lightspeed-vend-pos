<?php

namespace App\Repositories;

use App\Models\35;
use Illuminate\Database\Eloquent\Collection;

class 35Repository {

    public function findById($id): ?35 {
        return 35::find($id);
    }

    public function getAll(): Collection {
        return 35::all();
    }

    public function create(array $data): 35 {
        return 35::create($data);
    }

    public function update($id, array $data): bool {
        return 35::find($id)->update($data);
    }

    public function delete($id): bool {
        return 35::destroy($id) > 0;
    }
}