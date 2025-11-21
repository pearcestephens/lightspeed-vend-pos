<?php

namespace App\Repositories;

use App\Models\25;
use Illuminate\Database\Eloquent\Collection;

class 25Repository {

    public function findById($id): ?25 {
        return 25::find($id);
    }

    public function getAll(): Collection {
        return 25::all();
    }

    public function create(array $data): 25 {
        return 25::create($data);
    }

    public function update($id, array $data): bool {
        return 25::find($id)->update($data);
    }

    public function delete($id): bool {
        return 25::destroy($id) > 0;
    }
}