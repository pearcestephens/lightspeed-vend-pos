<?php

namespace App\Repositories;

use App\Models\44;
use Illuminate\Database\Eloquent\Collection;

class 44Repository {

    public function findById($id): ?44 {
        return 44::find($id);
    }

    public function getAll(): Collection {
        return 44::all();
    }

    public function create(array $data): 44 {
        return 44::create($data);
    }

    public function update($id, array $data): bool {
        return 44::find($id)->update($data);
    }

    public function delete($id): bool {
        return 44::destroy($id) > 0;
    }
}