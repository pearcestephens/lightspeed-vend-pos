<?php

namespace App\Repositories;

use App\Models\9;
use Illuminate\Database\Eloquent\Collection;

class 9Repository {

    public function findById($id): ?9 {
        return 9::find($id);
    }

    public function getAll(): Collection {
        return 9::all();
    }

    public function create(array $data): 9 {
        return 9::create($data);
    }

    public function update($id, array $data): bool {
        return 9::find($id)->update($data);
    }

    public function delete($id): bool {
        return 9::destroy($id) > 0;
    }
}