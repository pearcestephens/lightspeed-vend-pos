<?php

namespace App\Repositories;

use App\Models\65;
use Illuminate\Database\Eloquent\Collection;

class 65Repository {

    public function findById($id): ?65 {
        return 65::find($id);
    }

    public function getAll(): Collection {
        return 65::all();
    }

    public function create(array $data): 65 {
        return 65::create($data);
    }

    public function update($id, array $data): bool {
        return 65::find($id)->update($data);
    }

    public function delete($id): bool {
        return 65::destroy($id) > 0;
    }
}