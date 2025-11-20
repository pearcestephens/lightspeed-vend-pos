<?php

namespace App\Repositories;

use App\Models\26;
use Illuminate\Database\Eloquent\Collection;

class 26Repository {

    public function findById($id): ?26 {
        return 26::find($id);
    }

    public function getAll(): Collection {
        return 26::all();
    }

    public function create(array $data): 26 {
        return 26::create($data);
    }

    public function update($id, array $data): bool {
        return 26::find($id)->update($data);
    }

    public function delete($id): bool {
        return 26::destroy($id) > 0;
    }
}