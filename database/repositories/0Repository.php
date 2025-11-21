<?php

namespace App\Repositories;

use App\Models\0;
use Illuminate\Database\Eloquent\Collection;

class 0Repository {

    public function findById($id): ?0 {
        return 0::find($id);
    }

    public function getAll(): Collection {
        return 0::all();
    }

    public function create(array $data): 0 {
        return 0::create($data);
    }

    public function update($id, array $data): bool {
        return 0::find($id)->update($data);
    }

    public function delete($id): bool {
        return 0::destroy($id) > 0;
    }
}