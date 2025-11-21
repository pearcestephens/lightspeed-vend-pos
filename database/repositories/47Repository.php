<?php

namespace App\Repositories;

use App\Models\47;
use Illuminate\Database\Eloquent\Collection;

class 47Repository {

    public function findById($id): ?47 {
        return 47::find($id);
    }

    public function getAll(): Collection {
        return 47::all();
    }

    public function create(array $data): 47 {
        return 47::create($data);
    }

    public function update($id, array $data): bool {
        return 47::find($id)->update($data);
    }

    public function delete($id): bool {
        return 47::destroy($id) > 0;
    }
}