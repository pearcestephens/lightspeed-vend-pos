<?php

namespace App\Repositories;

use App\Models\63;
use Illuminate\Database\Eloquent\Collection;

class 63Repository {

    public function findById($id): ?63 {
        return 63::find($id);
    }

    public function getAll(): Collection {
        return 63::all();
    }

    public function create(array $data): 63 {
        return 63::create($data);
    }

    public function update($id, array $data): bool {
        return 63::find($id)->update($data);
    }

    public function delete($id): bool {
        return 63::destroy($id) > 0;
    }
}