<?php

namespace App\Repositories;

use App\Models\29;
use Illuminate\Database\Eloquent\Collection;

class 29Repository {

    public function findById($id): ?29 {
        return 29::find($id);
    }

    public function getAll(): Collection {
        return 29::all();
    }

    public function create(array $data): 29 {
        return 29::create($data);
    }

    public function update($id, array $data): bool {
        return 29::find($id)->update($data);
    }

    public function delete($id): bool {
        return 29::destroy($id) > 0;
    }
}