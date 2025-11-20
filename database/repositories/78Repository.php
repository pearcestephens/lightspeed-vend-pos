<?php

namespace App\Repositories;

use App\Models\78;
use Illuminate\Database\Eloquent\Collection;

class 78Repository {

    public function findById($id): ?78 {
        return 78::find($id);
    }

    public function getAll(): Collection {
        return 78::all();
    }

    public function create(array $data): 78 {
        return 78::create($data);
    }

    public function update($id, array $data): bool {
        return 78::find($id)->update($data);
    }

    public function delete($id): bool {
        return 78::destroy($id) > 0;
    }
}