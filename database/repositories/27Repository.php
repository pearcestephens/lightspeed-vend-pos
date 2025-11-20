<?php

namespace App\Repositories;

use App\Models\27;
use Illuminate\Database\Eloquent\Collection;

class 27Repository {

    public function findById($id): ?27 {
        return 27::find($id);
    }

    public function getAll(): Collection {
        return 27::all();
    }

    public function create(array $data): 27 {
        return 27::create($data);
    }

    public function update($id, array $data): bool {
        return 27::find($id)->update($data);
    }

    public function delete($id): bool {
        return 27::destroy($id) > 0;
    }
}