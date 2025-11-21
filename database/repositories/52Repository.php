<?php

namespace App\Repositories;

use App\Models\52;
use Illuminate\Database\Eloquent\Collection;

class 52Repository {

    public function findById($id): ?52 {
        return 52::find($id);
    }

    public function getAll(): Collection {
        return 52::all();
    }

    public function create(array $data): 52 {
        return 52::create($data);
    }

    public function update($id, array $data): bool {
        return 52::find($id)->update($data);
    }

    public function delete($id): bool {
        return 52::destroy($id) > 0;
    }
}