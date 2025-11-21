<?php

namespace App\Repositories;

use App\Models\56;
use Illuminate\Database\Eloquent\Collection;

class 56Repository {

    public function findById($id): ?56 {
        return 56::find($id);
    }

    public function getAll(): Collection {
        return 56::all();
    }

    public function create(array $data): 56 {
        return 56::create($data);
    }

    public function update($id, array $data): bool {
        return 56::find($id)->update($data);
    }

    public function delete($id): bool {
        return 56::destroy($id) > 0;
    }
}