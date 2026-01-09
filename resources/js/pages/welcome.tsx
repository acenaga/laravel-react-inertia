import { PageWrapper } from "@/components/PageWrapper";
import { Container } from "@/components/Container";
import { Header } from "@/components/Header";
import { Search } from "@/components/Search";
import { Shortlist } from "@/components/Shortlist";
import { PuppiesList } from "@/components/PuppiesList";
import { NewPuppyForm } from "@/components/NewPuppyForm";
import { useState } from "react";

import { Puppy, SharedData } from "@/types";
import { usePage } from "@inertiajs/react";


export default function App({ puppies }: { puppies: Puppy[] }) {
    return (
        <PageWrapper>
            <Container>
                <Header />
                <Main intertiaPuppies={puppies} />
            </Container>
        </PageWrapper>

    )
}



function Main({ intertiaPuppies }: { intertiaPuppies: Puppy[] }) {
    const [searchQuery, setSearchQuery] = useState("");
    const [puppies, setPuppies] = useState<Puppy[]>(intertiaPuppies);
    const { auth } = usePage<SharedData>().props;
    return (
        <main>
            {/* Search & Shortlist */}
            <div className="mt-24 grid gap-8 sm:grid-cols-2">
                {/* Search */}
                <Search searchQuery={searchQuery} setSearchQuery={setSearchQuery} />
                {/* Shortlist */}
                {auth.user && (
                    <Shortlist puppies={intertiaPuppies} setPuppies={setPuppies} />
                )}
            </div>
            {/* Puppies list */}
            <PuppiesList
                searchQuery={searchQuery}
                puppies={intertiaPuppies}
            />
            {/* New Puppy form */}
            <NewPuppyForm puppies={intertiaPuppies} setPuppies={setPuppies} />
        </main>

    )
}
