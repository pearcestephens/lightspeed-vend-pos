<?php

namespace App\Repositories;

use App\Models\77;
use Illuminate\Database\Eloquent\Collection;

class 77Repository {

    public function findById($id): ?77 {
        return 77::find($id);
    }

    public function getAll(): Collection {
        return 77::all();
    }

    public function create(array $data): 77 {
        return 77::create($data);
    }

    public function update($id, array $data): bool {
        return 77::find($id)->update($data);
    }

    public function delete($id): bool {
        return 77::destroy($id) > 0;
    }
}