<?php

namespace App\Repositories;

use App\Models\33;
use Illuminate\Database\Eloquent\Collection;

class 33Repository {

    public function findById($id): ?33 {
        return 33::find($id);
    }

    public function getAll(): Collection {
        return 33::all();
    }

    public function create(array $data): 33 {
        return 33::create($data);
    }

    public function update($id, array $data): bool {
        return 33::find($id)->update($data);
    }

    public function delete($id): bool {
        return 33::destroy($id) > 0;
    }
}