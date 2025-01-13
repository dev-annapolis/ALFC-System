<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Log;
// use App\Models\YourModel;

class DataImport implements ToCollection, WithHeadingRow 
{
    use Importable;

    public function collection(Collection $collection)
    {

        // DECLARE VARIABLES
        $error = false;
        $errorMessage = '';
        $missingIssuanceCodes = [];
        $missingAssuredNames = [];

        // COLLECT MISSING ISSUANCE CODE
        foreach ($collection as $index => $row) {
            if (empty($row['issuance_code'])) {
                $missingIssuanceCodes[] = $index + 2;
            }
        }
        if (count($missingIssuanceCodes) > 0) {
            $error = true;
            $errorMessage .= 'Missing ISSUANCE CODE at rows: ' . implode(', ', $missingIssuanceCodes);
            $errorMessage .= "\n";  // Add newline for separation
            $errorMessage .= "\n";  // Add newline for separation
        }

        // COLLECT MISSING ASSURED NAME
        foreach ($collection as $index => $row) {
            if (empty($row['assured_name'])) {
                $missingAssuredNames[] = $index + 2;
            }
        }
        if (count($missingAssuredNames) > 0) {
            $error = true;
            $errorMessage .= 'Missing ASSURED NAME at rows: ' . implode(', ', $missingAssuredNames);
            $errorMessage .= "\n";  // Add newline for separation
            $errorMessage .= "\n";  // Add newline for separation
        }

        // THROW MISSING ROWS TO MODAL IF HAS ERROR TRUE
        if ($error) {
            $errorMessage = str_replace("\n", '<br>', $errorMessage);  // Replace \n with <br>
            throw new \Exception($errorMessage);
        } else {
            DB::beginTransaction();
            try {
                foreach ($collection as $index => $row) {

                    // $row['assured_name']

                }
                DB::commit(); // COMMIT UPLOADED DATA IF NO ERRORS
            } catch (\Exception $e) {
                DB::rollBack(); // ROLLBACK TO REMOVE UPLOADED DATA INCASE OF UPLOADING ERROR
                throw $e; // SEND ERROR TO MODAL
            }
        }
    }


    public function headingRow(): int
    {
        return 1; // SET ROW 1 AS HEADING ROW
    }
}
