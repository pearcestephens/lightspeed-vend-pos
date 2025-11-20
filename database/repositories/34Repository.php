<?php

namespace App\Repositories;

use App\Models\34;
use Illuminate\Database\Eloquent\Collection;

class 34Repository {

    public function findById($id): ?34 {
        return 34::find($id);
    }

    public function getAll(): Collection {
        return 34::all();
    }

    public function create(array $data): 34 {
        return 34::create($data);
    }

    public function update($id, array $data): bool {
        return 34::find($id)->update($data);
    }

    public function delete($id): bool {
        return 34::destroy($id) > 0;
    }
}