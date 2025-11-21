<?php

namespace App\Repositories;

use App\Models\70;
use Illuminate\Database\Eloquent\Collection;

class 70Repository {

    public function findById($id): ?70 {
        return 70::find($id);
    }

    public function getAll(): Collection {
        return 70::all();
    }

    public function create(array $data): 70 {
        return 70::create($data);
    }

    public function update($id, array $data): bool {
        return 70::find($id)->update($data);
    }

    public function delete($id): bool {
        return 70::destroy($id) > 0;
    }
}