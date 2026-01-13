import { PageWrapper } from "@/components/PageWrapper";
import { Container } from "@/components/Container";
import { Header } from "@/components/Header";
import { Search } from "@/components/Search";
import { Shortlist } from "@/components/Shortlist";
import { PuppiesList } from "@/components/PuppiesList";
import { NewPuppyForm } from "@/components/NewPuppyForm";
import { useState } from "react";

import { Filters, PaginatedResponse, Puppy, SharedData } from "@/types";
import { usePage } from "@inertiajs/react";


export default function App({ puppies, filters }: { puppies: PaginatedResponse<Puppy>; filters: Filters }) {
    return (
        <PageWrapper>
            <Container>
                <Header />
                <Main paginatedPuppies={puppies} filters={filters} />
            </Container>
        </PageWrapper>

    )
}



function Main({ paginatedPuppies, filters }: { paginatedPuppies: PaginatedResponse<Puppy>; filters: Filters }) {
    const { auth } = usePage<SharedData>().props;
    return (
        <main>
            {/* Search & Shortlist */}
            <div className="mt-24 grid gap-8 sm:grid-cols-2">
                {/* Search */}
                <Search filters={filters} />
                {/* Shortlist */}
                {auth.user && (
                    <Shortlist puppies={paginatedPuppies.data} />
                )}
            </div>
            {/* Puppies list */}
            <PuppiesList
                puppies={paginatedPuppies}
            />
            {/* New Puppy form */}
            {auth.user &&(
                <NewPuppyForm />
            )}
        </main>

    )
}
