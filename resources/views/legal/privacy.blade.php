@extends('layouts.app')

@section('title', 'Privacy Policy | RetailPulse')

@section('content')
    <div class="mx-auto max-w-3xl border border-gray-300 bg-white p-6 lg:p-8">
        <p class="text-sm text-gray-600">Effective date: September 18, 2026</p>

        <h1 class="mt-2 text-2xl font-semibold text-gray-900">Privacy Policy</h1>

        <p class="mt-4 text-sm leading-6 text-gray-800">
            This Privacy Policy explains how the RetailPulse Dashboard UI demonstration project handles information.
            The project is fictional and is intended for portfolio review. This policy is illustrative and is not legal advice.
        </p>

        <section class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900">1. Information We Collect</h2>
            <p class="mt-2 text-sm leading-6 text-gray-800">
                The interface may collect basic technical data such as browser type, device type, approximate locale,
                and interaction events needed to demonstrate UI behavior. Demo forms may capture entered values locally
                for presentation purposes.
            </p>
        </section>

        <section class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900">2. How We Use Information</h2>
            <p class="mt-2 text-sm leading-6 text-gray-800">
                Information is used to render the demonstration, preserve local preferences such as sidebar state and
                contrast setting, and evaluate interface responsiveness. It is not used for advertising or profiling.
            </p>
        </section>

        <section class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900">3. Local Storage</h2>
            <p class="mt-2 text-sm leading-6 text-gray-800">
                The project uses browser local storage to remember UI preferences. Examples include collapsed sidebar
                state, contrast preference, and held POS orders during a session. You can clear local storage through
                your browser settings.
            </p>
        </section>

        <section class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900">4. Shared Information</h2>
            <p class="mt-2 text-sm leading-6 text-gray-800">
                The demonstration does not sell personal information. It does not share personal information with third
                parties for marketing purposes. Hosting providers may process standard server logs according to their
                own policies.
            </p>
        </section>

        <section class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900">5. Cookies and Similar Technologies</h2>
            <p class="mt-2 text-sm leading-6 text-gray-800">
                The project may use session cookies required by the framework and local storage entries for interface
                preferences. It does not use tracking pixels for behavioral advertising.
            </p>
        </section>

        <section class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900">6. Data Retention</h2>
            <p class="mt-2 text-sm leading-6 text-gray-800">
                Demo data is retained only as long as needed for review or until cleared by the user or host. Local
                storage values remain on your device until removed by you or by the browser.
            </p>
        </section>

        <section class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900">7. Your Rights</h2>
            <p class="mt-2 text-sm leading-6 text-gray-800">
                Depending on your jurisdiction, you may have rights to access, correct, delete, or restrict processing of
                personal data. Because this is a fictional demo, most records are synthetic and not tied to real people.
            </p>
        </section>

        <section class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900">8. Security</h2>
            <p class="mt-2 text-sm leading-6 text-gray-800">
                Reasonable administrative and technical measures are used to protect the demonstration environment.
                No online system can guarantee complete security.
            </p>
        </section>

        <section class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900">9. Children</h2>
            <p class="mt-2 text-sm leading-6 text-gray-800">
                The project is not directed to children. It is intended for professional review and development testing.
            </p>
        </section>

        <section class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900">10. Changes</h2>
            <p class="mt-2 text-sm leading-6 text-gray-800">
                This policy may be updated as the project evolves. The effective date at the top of the page indicates
                the latest revision.
            </p>
        </section>

        <section class="mt-8">
            <h2 class="text-lg font-semibold text-gray-900">11. Contact</h2>
            <p class="mt-2 text-sm leading-6 text-gray-800">
                Privacy questions for this demonstration can be sent to the project maintainer through the repository
                contact details.
            </p>
        </section>
    </div>
@endsection
