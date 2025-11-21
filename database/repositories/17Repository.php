<?php

namespace App\Repositories;

use App\Models\17;
use Illuminate\Database\Eloquent\Collection;

class 17Repository {

    public function findById($id): ?17 {
        return 17::find($id);
    }

    public function getAll(): Collection {
        return 17::all();
    }

    public function create(array $data): 17 {
        return 17::create($data);
    }

    public function update($id, array $data): bool {
        return 17::find($id)->update($data);
    }

    public function delete($id): bool {
        return 17::destroy($id) > 0;
    }
}