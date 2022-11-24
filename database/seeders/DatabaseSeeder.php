<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $this->call(TmpSubscriptionsTableSeeder::class);
        $this->call(AdminLevelPermissionsTableSeeder::class);
        $this->call(AdminLevelsTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(FailedJobsTableSeeder::class);
        $this->call(InvoiceItemsTableSeeder::class);
        $this->call(IpLocationsTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(MigrationsTableSeeder::class);
        $this->call(OauthAccessTokensTableSeeder::class);
        $this->call(OauthAuthCodesTableSeeder::class);
        $this->call(OauthClientsTableSeeder::class);
        $this->call(OauthPersonalAccessClientsTableSeeder::class);
        $this->call(OauthRefreshTokensTableSeeder::class);
        $this->call(PasswordResetsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(SessionsTableSeeder::class);
        $this->call(SubscriptionLogsTableSeeder::class);
        $this->call(TeamUserTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(TenantsTableSeeder::class);
        $this->call(TransactionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(WebsocketsStatisticsEntriesTableSeeder::class);

        $this->call(BillingAddressesTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(DomainsTableSeeder::class);
        $this->call(InvoicesTableSeeder::class);
        $this->call(PlanPricesTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(SubscriptionsTableSeeder::class);
        $this->call(TeamInvitationsTableSeeder::class);
        $this->call(PaymentServiceProviderSeeder::class);
        $this->call(PaypalRegisteredPlansTableSeeder::class);
        $this->call(PaymentServiceProviderSupportedCurrenciesTableSeeder::class);
    }
}
