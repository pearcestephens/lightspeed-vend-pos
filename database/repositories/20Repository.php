<?php

namespace App\Repositories;

use App\Models\20;
use Illuminate\Database\Eloquent\Collection;

class 20Repository {

    public function findById($id): ?20 {
        return 20::find($id);
    }

    public function getAll(): Collection {
        return 20::all();
    }

    public function create(array $data): 20 {
        return 20::create($data);
    }

    public function update($id, array $data): bool {
        return 20::find($id)->update($data);
    }

    public function delete($id): bool {
        return 20::destroy($id) > 0;
    }
}