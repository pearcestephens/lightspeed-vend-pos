<?php

namespace App\Repositories;

use App\Models\11;
use Illuminate\Database\Eloquent\Collection;

class 11Repository {

    public function findById($id): ?11 {
        return 11::find($id);
    }

    public function getAll(): Collection {
        return 11::all();
    }

    public function create(array $data): 11 {
        return 11::create($data);
    }

    public function update($id, array $data): bool {
        return 11::find($id)->update($data);
    }

    public function delete($id): bool {
        return 11::destroy($id) > 0;
    }
}