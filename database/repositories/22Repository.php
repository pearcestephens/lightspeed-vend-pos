<?php

namespace App\Repositories;

use App\Models\22;
use Illuminate\Database\Eloquent\Collection;

class 22Repository {

    public function findById($id): ?22 {
        return 22::find($id);
    }

    public function getAll(): Collection {
        return 22::all();
    }

    public function create(array $data): 22 {
        return 22::create($data);
    }

    public function update($id, array $data): bool {
        return 22::find($id)->update($data);
    }

    public function delete($id): bool {
        return 22::destroy($id) > 0;
    }
}