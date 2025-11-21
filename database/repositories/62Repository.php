<?php

namespace App\Repositories;

use App\Models\62;
use Illuminate\Database\Eloquent\Collection;

class 62Repository {

    public function findById($id): ?62 {
        return 62::find($id);
    }

    public function getAll(): Collection {
        return 62::all();
    }

    public function create(array $data): 62 {
        return 62::create($data);
    }

    public function update($id, array $data): bool {
        return 62::find($id)->update($data);
    }

    public function delete($id): bool {
        return 62::destroy($id) > 0;
    }
}