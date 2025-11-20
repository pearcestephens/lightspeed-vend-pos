<?php

namespace App\Repositories;

use App\Models\13;
use Illuminate\Database\Eloquent\Collection;

class 13Repository {

    public function findById($id): ?13 {
        return 13::find($id);
    }

    public function getAll(): Collection {
        return 13::all();
    }

    public function create(array $data): 13 {
        return 13::create($data);
    }

    public function update($id, array $data): bool {
        return 13::find($id)->update($data);
    }

    public function delete($id): bool {
        return 13::destroy($id) > 0;
    }
}