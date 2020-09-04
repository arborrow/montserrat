<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CivicrmParticipantStatusTypeTableSeeder::class);
        $this->call(ContactTableSeeder::class);
        $this->call(ContactLanguagesTableSeeder::class);
        $this->call(ContactReferralTableSeeder::class);
        $this->call(ContactTypeTableSeeder::class);
        $this->call(CountryTableSeeder::class);
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
        $this->call(StateProvinceTableSeeder::class);
        $this->call(SuffixTableSeeder::class);
        $this->call(TouchcategoriesTableSeeder::class);
        $this->call(DonationTypeTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(UomTableSeeder::class);
        $this->call(AssetTypeTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        // permissions
        $this->call(AssetPermissionsSeeder::class);
        $this->call(DepartmentPermissionsSeeder::class);
        $this->call(SnippetPermissionsSeeder::class);
        $this->call(WebsitePermissionsSeeder::class);

    }
}
