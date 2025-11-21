<?php

namespace App\Repositories;

use App\Models\46;
use Illuminate\Database\Eloquent\Collection;

class 46Repository {

    public function findById($id): ?46 {
        return 46::find($id);
    }

    public function getAll(): Collection {
        return 46::all();
    }

    public function create(array $data): 46 {
        return 46::create($data);
    }

    public function update($id, array $data): bool {
        return 46::find($id)->update($data);
    }

    public function delete($id): bool {
        return 46::destroy($id) > 0;
    }
}