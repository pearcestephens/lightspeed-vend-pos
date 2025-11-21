<?php

namespace App\Repositories;

use App\Models\7;
use Illuminate\Database\Eloquent\Collection;

class 7Repository {

    public function findById($id): ?7 {
        return 7::find($id);
    }

    public function getAll(): Collection {
        return 7::all();
    }

    public function create(array $data): 7 {
        return 7::create($data);
    }

    public function update($id, array $data): bool {
        return 7::find($id)->update($data);
    }

    public function delete($id): bool {
        return 7::destroy($id) > 0;
    }
}