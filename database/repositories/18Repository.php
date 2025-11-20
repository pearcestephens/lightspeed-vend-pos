<?php

namespace App\Repositories;

use App\Models\18;
use Illuminate\Database\Eloquent\Collection;

class 18Repository {

    public function findById($id): ?18 {
        return 18::find($id);
    }

    public function getAll(): Collection {
        return 18::all();
    }

    public function create(array $data): 18 {
        return 18::create($data);
    }

    public function update($id, array $data): bool {
        return 18::find($id)->update($data);
    }

    public function delete($id): bool {
        return 18::destroy($id) > 0;
    }
}