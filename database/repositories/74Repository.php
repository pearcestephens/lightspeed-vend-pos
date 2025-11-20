<?php

namespace App\Repositories;

use App\Models\74;
use Illuminate\Database\Eloquent\Collection;

class 74Repository {

    public function findById($id): ?74 {
        return 74::find($id);
    }

    public function getAll(): Collection {
        return 74::all();
    }

    public function create(array $data): 74 {
        return 74::create($data);
    }

    public function update($id, array $data): bool {
        return 74::find($id)->update($data);
    }

    public function delete($id): bool {
        return 74::destroy($id) > 0;
    }
}