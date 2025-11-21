<?php

namespace App\Repositories;

use App\Models\50;
use Illuminate\Database\Eloquent\Collection;

class 50Repository {

    public function findById($id): ?50 {
        return 50::find($id);
    }

    public function getAll(): Collection {
        return 50::all();
    }

    public function create(array $data): 50 {
        return 50::create($data);
    }

    public function update($id, array $data): bool {
        return 50::find($id)->update($data);
    }

    public function delete($id): bool {
        return 50::destroy($id) > 0;
    }
}