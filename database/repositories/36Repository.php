<?php

namespace App\Repositories;

use App\Models\36;
use Illuminate\Database\Eloquent\Collection;

class 36Repository {

    public function findById($id): ?36 {
        return 36::find($id);
    }

    public function getAll(): Collection {
        return 36::all();
    }

    public function create(array $data): 36 {
        return 36::create($data);
    }

    public function update($id, array $data): bool {
        return 36::find($id)->update($data);
    }

    public function delete($id): bool {
        return 36::destroy($id) > 0;
    }
}