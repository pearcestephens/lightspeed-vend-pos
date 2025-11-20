<?php

namespace App\Repositories;

use App\Models\60;
use Illuminate\Database\Eloquent\Collection;

class 60Repository {

    public function findById($id): ?60 {
        return 60::find($id);
    }

    public function getAll(): Collection {
        return 60::all();
    }

    public function create(array $data): 60 {
        return 60::create($data);
    }

    public function update($id, array $data): bool {
        return 60::find($id)->update($data);
    }

    public function delete($id): bool {
        return 60::destroy($id) > 0;
    }
}