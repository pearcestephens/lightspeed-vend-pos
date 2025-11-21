<?php

namespace App\Repositories;

use App\Models\40;
use Illuminate\Database\Eloquent\Collection;

class 40Repository {

    public function findById($id): ?40 {
        return 40::find($id);
    }

    public function getAll(): Collection {
        return 40::all();
    }

    public function create(array $data): 40 {
        return 40::create($data);
    }

    public function update($id, array $data): bool {
        return 40::find($id)->update($data);
    }

    public function delete($id): bool {
        return 40::destroy($id) > 0;
    }
}