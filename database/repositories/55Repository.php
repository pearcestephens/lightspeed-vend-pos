<?php

namespace App\Repositories;

use App\Models\55;
use Illuminate\Database\Eloquent\Collection;

class 55Repository {

    public function findById($id): ?55 {
        return 55::find($id);
    }

    public function getAll(): Collection {
        return 55::all();
    }

    public function create(array $data): 55 {
        return 55::create($data);
    }

    public function update($id, array $data): bool {
        return 55::find($id)->update($data);
    }

    public function delete($id): bool {
        return 55::destroy($id) > 0;
    }
}