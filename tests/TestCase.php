<?php

namespace Rcoenen\KnowledgeBaseHelpCenter\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use JeffersonGoncalves\KnowledgeBase\KnowledgeBaseServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Rcoenen\KnowledgeBaseHelpCenter\Database\Seeders\HelpCenterDemoSeeder;
use Rcoenen\KnowledgeBaseHelpCenter\HelpCenterServiceProvider;
use Rcoenen\KnowledgeBaseHelpCenter\Tests\Fixtures\User;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected bool $enabled = true;

    protected function getPackageProviders($app): array
    {
        return [
            KnowledgeBaseServiceProvider::class,
            HelpCenterServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(str_repeat('k', 32)));
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '']);
        $app['config']->set('auth.providers.users.model', User::class);

        $app['config']->set('knowledge-base.locales', ['en', 'de']);
        $app['config']->set('knowledge-base.default_locale', 'en');
        $app['config']->set('knowledge-base.missing_translation', 'fallback');

        $app['config']->set('knowledge-base-help-center.enabled', $this->enabled);
    }

    /**
     * Run the core package's migration stubs in their dependency order, after
     * Laravel's own (users) migrations.
     */
    protected function defineDatabaseMigrations(): void
    {
        $core = dirname((new \ReflectionClass(KnowledgeBaseServiceProvider::class))->getFileName(), 2).'/database/migrations';
        $temp = sys_get_temp_dir().'/kb-help-center-migrations';

        if (! is_dir($temp)) {
            mkdir($temp, 0755, true);
        }

        foreach ([
            'create_kb_categories_table',
            'create_kb_articles_table',
            'create_kb_article_versions_table',
            'create_kb_article_feedback_table',
            'create_kb_article_relations_table',
            'add_kb_content_localization',
            'add_kb_collections',
        ] as $index => $name) {
            copy($core.'/'.$name.'.php.stub', $temp.'/'.sprintf('2026_01_01_%06d_%s.php', $index, $name));
        }

        file_put_contents($temp.'/2025_01_01_000000_create_users_table.php', <<<'PHP'
        <?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        return new class extends Migration
        {
            public function up(): void
            {
                Schema::create('users', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('email')->unique();
                    $table->string('password');
                    $table->timestamps();
                });
            }
        };
        PHP);

        $this->loadMigrationsFrom($temp);
    }

    protected function seedDemo(): void
    {
        $this->seed(HelpCenterDemoSeeder::class);
    }
}
