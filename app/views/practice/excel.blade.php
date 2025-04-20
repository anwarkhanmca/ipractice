<div class="col-4">
        <h1 style="color:blue">{{strtoupper($title) }}</h1>
    </div>

<table>
    <thead>
        <tr>
            <th>Display Name</th>
            <th>Legal/Trading Name</th>
            <th>Registration Number</th>
            <th>Organisation Type</th>

            <th>Reg_Attention</th>
            <th>Reg_Street Address or PO Box</th>
            <th>Reg_Town/City</th>
            <th>Reg_State/Region</th>
            <th>Reg_Postal/Zip Code</th>
            <th>Reg_Country</th>

             <th>Phy_Attention</th>
            <th>Phy_Street Address or PO Box</th>
            <th>Phy_Town/City</th>
            <th>Phy_State/Region</th>
            <th>Phy_Postal/Zip Code</th>
            <th>Phy_Country</th>

            <th>Telephone</th>

            <th>Fax</th>

            <th>Mobile</th>




        </tr>
    </thead>

    <tbody>

        <tr>
            <td>{{ $practice_details->display_name or '' }}</td>
            <td>{{ $practice_details->legal_name or '' }}</td>
            <td>{{ $practice_details->registration_no or '' }}</td>
            <td>{{ $organization_type_name->name or '' }}</td>

            <td>{{ $practice_address['reg_attention'] or '' }}</td>
            <td>{{ $practice_address['reg_street_address'] or ''}}</td>
            <td>{{ $practice_address['reg_city_name'] or '' }}</td>
            <td>{{ $practice_address['reg_state_name'] or '' }}</td>
            <td>{{ $practice_address['reg_zip'] or '' }}</td>
            <td>United Kingdom</td>

            <td>{{ $practice_address['phy_attention'] or '' }}</td>
            <td>{{ $practice_address['phy_street_address'] or ''}}</td>
            <td>{{ $practice_address['phy_city_name'] or '' }}"</td>
            <td>{{ $practice_address['phy_state_name'] or ''}}</td>
            <td>{{ $practice_address['phy_zip'] or '' }}</td>
            <td>United Kingdom</td>

            <td>{{ $practice_details['telephone_no'][0] or '' }} {{ $practice_details['telephone_no'][1] or '' }} {{ $practice_details['telephone_no'][2] or '' }}</td>

            <td>{{ $practice_details['fax_no'][0] or '' }} {{ $practice_details['fax_no'][1] or '' }} {{ $practice_details['fax_no'][2] or '' }}</td>

            <td>{{ $practice_details['mobile_no'][0] or '' }} {{ $practice_details['mobile_no'][1] or '' }} {{ $practice_details['mobile_no'][2] or '' }}</td>


    </tbody>
</table>