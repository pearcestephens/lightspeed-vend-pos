<?php

namespace App\Repositories;

use App\Models\71;
use Illuminate\Database\Eloquent\Collection;

class 71Repository {

    public function findById($id): ?71 {
        return 71::find($id);
    }

    public function getAll(): Collection {
        return 71::all();
    }

    public function create(array $data): 71 {
        return 71::create($data);
    }

    public function update($id, array $data): bool {
        return 71::find($id)->update($data);
    }

    public function delete($id): bool {
        return 71::destroy($id) > 0;
    }
}