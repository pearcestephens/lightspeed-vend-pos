<?php

namespace App\Repositories;

use App\Models\79;
use Illuminate\Database\Eloquent\Collection;

class 79Repository {

    public function findById($id): ?79 {
        return 79::find($id);
    }

    public function getAll(): Collection {
        return 79::all();
    }

    public function create(array $data): 79 {
        return 79::create($data);
    }

    public function update($id, array $data): bool {
        return 79::find($id)->update($data);
    }

    public function delete($id): bool {
        return 79::destroy($id) > 0;
    }
}