<?php

namespace App\Repositories;

use App\Models\75;
use Illuminate\Database\Eloquent\Collection;

class 75Repository {

    public function findById($id): ?75 {
        return 75::find($id);
    }

    public function getAll(): Collection {
        return 75::all();
    }

    public function create(array $data): 75 {
        return 75::create($data);
    }

    public function update($id, array $data): bool {
        return 75::find($id)->update($data);
    }

    public function delete($id): bool {
        return 75::destroy($id) > 0;
    }
}