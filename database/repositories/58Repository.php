<?php

namespace App\Repositories;

use App\Models\58;
use Illuminate\Database\Eloquent\Collection;

class 58Repository {

    public function findById($id): ?58 {
        return 58::find($id);
    }

    public function getAll(): Collection {
        return 58::all();
    }

    public function create(array $data): 58 {
        return 58::create($data);
    }

    public function update($id, array $data): bool {
        return 58::find($id)->update($data);
    }

    public function delete($id): bool {
        return 58::destroy($id) > 0;
    }
}