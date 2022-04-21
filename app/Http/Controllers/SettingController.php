<?php

namespace App\Http\Controllers;

use App\RestoreDatabase;
use Artisan;
use Carbon\Carbon;
use Inertia\Inertia;
use Storage;
use Str;
class SettingController extends Controller
{
    const DATE_FORMAT = "Y-m-d-G-i-s";

    public function index()
    {
        // get latest file name
        $files = $this->getSortedBackupFiles();

        if (!$files) {
            // no files found
            return Inertia::render("Settings", [
                "has_backup" => true,
            ]);
        }

        $latestFileCreated = Carbon::createFromFormat(
            self::DATE_FORMAT,
            str_replace(".zip", "", $files[0])
        );

        return Inertia::render("Settings", [
            "file_name" => $latestFileCreated->format(self::DATE_FORMAT),
            "latest" => $latestFileCreated
                ->setTimezone("africa/cairo")
                ->format("Y/m/d G:i:sa"),
            "diff" => $latestFileCreated->diffForHumans(),
            // 'diff' => '',
        ]);
    }

    /**
     * download sql backup file
     *
     * @param string $fileName
     * @return Response
     */
    public function download(string $fileName)
    {
        $dir = Storage::disk("backupsDir");

        abort_if(!$dir->exists($fileName . ".zip"), 404);
        $fileName .= ".zip";

        $file = $dir->path($fileName);

        return response()->download($file, $fileName, [
            "Content-Type" => "application/sql",
        ]);
    }

    /**
     * backup database
     *
     * @return Response
     */
    public function backup()
    {
        Artisan::call("backup:clean");

        Artisan::call("backup:run --only-db");

        $files = $this->getSortedBackupFiles();

        if (!$files) {
            return response()->json(["done" => false]);
        }

        $isCreated = collect($files)->first(
            fn($x) => Str::contains($x, Carbon::now()->format("Y-m-d-G-i"))
        );

        if (!$isCreated) {
            return response()->json(["done" => false]);
        }

        return response()->json([
            "done" => true,
            "file_name" => $isCreated,
        ]);
    }

    public function restore()
    {
        ["sql" => $sql] = request()->validate([
            "sql" => "required|file",
        ]);

        // delete all old files
        Storage::disk('backups')->files();

        // upload file
        $fileName = "backup" . time() . $sql->getClientOriginalName();
        $path = "storage/" . $sql->storeAs("backups", $fileName, "public");

        $process = new RestoreDatabase($path);

        $done = $process->handle();

        return response()->json(compact("done"));
    }

    /**
     * get backup files and sort to get the latest file
     *
     * @return array|false
     */
    private function getSortedBackupFiles(): array|false
    {
        $files = Storage::disk("backupsDir")->files();

        if (sizeof($files) < 1) {
            return false;
        }

        usort($files, function ($a, $b) {
            $a = str_replace(".zip", "", $a);
            $b = str_replace(".zip", "", $b);
            $a = Carbon::createFromFormat(self::DATE_FORMAT, $a);
            $b = Carbon::createFromFormat(self::DATE_FORMAT, $b);
            return $a->greaterThan($b) ? -1 : 1;
        });

        return $files;
    }
}
