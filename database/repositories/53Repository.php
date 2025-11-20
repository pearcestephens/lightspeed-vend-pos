<?php

namespace App\Repositories;

use App\Models\53;
use Illuminate\Database\Eloquent\Collection;

class 53Repository {

    public function findById($id): ?53 {
        return 53::find($id);
    }

    public function getAll(): Collection {
        return 53::all();
    }

    public function create(array $data): 53 {
        return 53::create($data);
    }

    public function update($id, array $data): bool {
        return 53::find($id)->update($data);
    }

    public function delete($id): bool {
        return 53::destroy($id) > 0;
    }
}