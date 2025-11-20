<?php

namespace App\Repositories;

use App\Models\45;
use Illuminate\Database\Eloquent\Collection;

class 45Repository {

    public function findById($id): ?45 {
        return 45::find($id);
    }

    public function getAll(): Collection {
        return 45::all();
    }

    public function create(array $data): 45 {
        return 45::create($data);
    }

    public function update($id, array $data): bool {
        return 45::find($id)->update($data);
    }

    public function delete($id): bool {
        return 45::destroy($id) > 0;
    }
}