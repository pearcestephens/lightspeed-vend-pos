<?php

namespace App\Repositories;

use App\Models\19;
use Illuminate\Database\Eloquent\Collection;

class 19Repository {

    public function findById($id): ?19 {
        return 19::find($id);
    }

    public function getAll(): Collection {
        return 19::all();
    }

    public function create(array $data): 19 {
        return 19::create($data);
    }

    public function update($id, array $data): bool {
        return 19::find($id)->update($data);
    }

    public function delete($id): bool {
        return 19::destroy($id) > 0;
    }
}