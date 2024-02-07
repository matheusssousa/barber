import { useAuth } from "../providers/AuthProvider";

import PublicRoutes from './PublicRoutes';
import PrivateRoutesAdmin from "./Admin/PrivateRoutesAdmin";
import PrivateRoutesUser from "./User/PrivateRoutesUser";

const MyRoute = () => {
    const { authenticate, admin, user } = useAuth();

    if (authenticate === true) {
        if (admin) {
            return <PrivateRoutesAdmin />;
        } else if (user) {
            return <PrivateRoutesUser />;
        }
    } else if (authenticate === false) {
        return <PublicRoutes />;
    }
}

export default MyRoute;