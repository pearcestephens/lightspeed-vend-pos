<?php

namespace App\Repositories;

use App\Models\51;
use Illuminate\Database\Eloquent\Collection;

class 51Repository {

    public function findById($id): ?51 {
        return 51::find($id);
    }

    public function getAll(): Collection {
        return 51::all();
    }

    public function create(array $data): 51 {
        return 51::create($data);
    }

    public function update($id, array $data): bool {
        return 51::find($id)->update($data);
    }

    public function delete($id): bool {
        return 51::destroy($id) > 0;
    }
}