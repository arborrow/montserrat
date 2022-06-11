<?php

namespace Database\Seeders;

use Database\Seeders\AssetJobPermissionsSeeder;
use Database\Seeders\AssetPermissionsSeeder;
use Database\Seeders\AssetTaskPermissionsSeeder;
use Database\Seeders\AssetTypeTableSeeder;
use Database\Seeders\AuditPermissionsSeeder;
use Database\Seeders\CivicrmParticipantStatusTypeTableSeeder;
use Database\Seeders\ContactLanguagesTableSeeder;
use Database\Seeders\ContactReferralTableSeeder;
use Database\Seeders\ContactTableSeeder;
use Database\Seeders\ContactTypeTableSeeder;
use Database\Seeders\CountryTableSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AssetTypeTableSeeder::class);
        $this->call(CivicrmParticipantStatusTypeTableSeeder::class);
        $this->call(ContactTableSeeder::class);
        $this->call(ContactLanguagesTableSeeder::class);
        $this->call(ContactReferralTableSeeder::class);
        $this->call(ContactTypeTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(DonationTypeTableSeeder::class);
        $this->call(EthnicitiesTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(EventTypeTableSeeder::class);
        $this->call(FileTypeTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(GroupTableSeeder::class);
        $this->call(LanguageTableSeeder::class);
        $this->call(LocationTypeTableSeeder::class);
        $this->call(OccupationListTableSeeder::class);
        $this->call(ParticipantRoleTypeTableSeeder::class);
        $this->call(ParticipantStatusTypeTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PpdOccupationsTableSeeder::class);
        $this->call(PrefixTableSeeder::class);
        $this->call(ReferralTableSeeder::class);
        $this->call(RelationshipTypeTableSeeder::class);
        $this->call(ReligionTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(SalutationsTableSeeder::class);
        $this->call(SnippetsTableSeeder::class);
        $this->call(SsInventoryTableSeeder::class);
        $this->call(SsCustomFormTableSeeder::class);
        $this->call(SsCustomFormFieldTableSeeder::class);
        $this->call(StateProvinceTableSeeder::class);
        $this->call(SuffixTableSeeder::class);
        $this->call(TouchcategoriesTableSeeder::class);
        $this->call(UomTableSeeder::class);
        // permissions
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(AssetPermissionsSeeder::class);
        $this->call(AssetTaskPermissionsSeeder::class);
        $this->call(AssetJobPermissionsSeeder::class);
        $this->call(AuditPermissionsSeeder::class);
        $this->call(DepartmentPermissionsSeeder::class);
        $this->call(ExportListPermissionsSeeder::class);
        $this->call(SnippetPermissionsSeeder::class);
        $this->call(WebsitePermissionsSeeder::class);
        $this->call(MailgunPermissionsSeeder::class);
        $this->call(StripePermissionsSeeder::class);
        $this->call(SquarespaceContributionPermissionsSeeder::class);
        $this->call(SquarespaceOrderPermissionsSeeder::class);

    }
}
